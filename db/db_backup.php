#!/usr/bin/env php
<?php
/**
 * Скрипт автоматического бэкапа базы данных
 * Делает отдельно бэкап по каждой таблице, разбивая ее на два файла - структура и данные
 */

$config = include dirname(__FILE__).'/db_backup.config.inc.php';

$options = implode(' ', $config['options']);
$structureOptions = $options.' '.implode(' ', $config['structureOptions']);
$dataOptions = $options.' '.implode(' ',$config['dataOptions']);

$dataDir = dirname(__FILE__).'/dbdata';
$structureDir = dirname(__FILE__).'/dbstructure';
$sampleDbDir = dirname(__FILE__).'/dbsample';

$sampleDbFile = $sampleDbDir.'/sample_db.sql';

if(file_exists($sampleDbFile)){
    unlink($sampleDbFile);
}

/**
 * @param PDO $pdo
 * @return bool|array
 */
function listTables($pdo)
{
    $sql = 'SHOW TABLES';
    $query = $pdo->query($sql);
    return $query->fetchAll(PDO::FETCH_COLUMN);
}

$pdo = new PDO($config['db_dsn'],$config['db_user'],$config['db_password'],$config['db_options']);

$tables = listTables($pdo);
$fp = fopen($sampleDbFile, 'a+');
foreach ($tables as $table) {
    if(!in_array($table,$config['ignoreStructure'])){
        $filename = $structureDir.'/'.$table.'.sql';
        $cmd = 'mysqldump '.$structureOptions.' --result-file="' . $filename . '" '.$config['db_name'].' '.$table;
        system($cmd);
        //Пишем в общий файл
        fwrite($fp, file_get_contents($filename));

    }

    if(!in_array($table,$config['ignoreData']))
    {
        $filename = $dataDir . '/' . $table . '.sql';
        $cmd = 'mysqldump ' . $dataOptions . ' --result-file="' . $filename . '" ' . $config['db_name'] . ' ' . $table;
        system($cmd);
        //Пишем в общий файл
        fwrite($fp, file_get_contents($filename));
    }
}

fclose($fp);