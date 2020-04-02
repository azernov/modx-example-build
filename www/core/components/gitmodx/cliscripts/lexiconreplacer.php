#!/usr/bin/php
<?php
/**
 * Скрипт делает обход всех чанков и шаблонов и заменяет в них фразы лексикона на плейсхолдеры лексикона
 */

$templatesDir = dirname(dirname(__FILE__)).'/elements/templates';
$chunksDir = dirname(dirname(__FILE__)).'/elements/chunks';
$lexiconFile = dirname(dirname(dirname(__FILE__))).'/elvert/lexicon/ru/default.inc.php';

$_lang = array();
include $lexiconFile;

asort($_lang,SORT_STRING);

/**
 * @param $dirname
 * @param $filesPattern
 * @param $fileFunction - имя функции, принимающей на входе 1 параметр - полный путь к файлу
 */
function processDirectory($dirname, $filesPattern, $fileFunction)
{
    $cDir = opendir($dirname);
    while($filename = readdir($cDir))
    {
        if(is_dir($dirname.'/'.$filename) && $filename != '.' && $filename != '..')
        {
            processDirectory($dirname.'/'.$filename,$filesPattern, $fileFunction);
        }
        elseif(is_file($dirname.'/'.$filename) && preg_match($filesPattern,$filename))
        {
            echo 'Заменяем лексиконы в файле '.$filename."\n";
            $fileFunction($dirname.'/'.$filename);
        }
    }
    closedir($cDir);
}

function replaceLexicons($filePath)
{
    global $_lang;
    $content = file_get_contents($filePath);

    foreach($_lang as $lexiconKey => $lexiconPhrase)
    {
        //Делаем замену лексиконных фраз
        $content = str_ireplace($lexiconPhrase,'[[%'.$lexiconKey.']]',$content);
    }

    file_put_contents($filePath,$content);

}

processDirectory($chunksDir,'#\.tpl$#i','replaceLexicons');
processDirectory($templatesDir,'#\.html$#i','replaceLexicons');