#!/usr/bin/php
<?php
/**
 * Скрипт делает обход всех чанков и шаблонов, находит в них все фразы, которые могут быть в лексиконах и записывает их в файл лексикона
 */

$templatesDir = dirname(dirname(__FILE__)).'/elements/templates';
$chunksDir = dirname(dirname(__FILE__)).'/elements/chunks';
$lexiconFile = dirname(dirname(dirname(__FILE__))).'/changemeplease/lexicon/ru/frontend.inc.php';

$_lang = array();
include $lexiconFile;

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
            echo 'Ищем лексиконы в файле '.$filename."\n";
            $fileFunction($dirname.'/'.$filename);
        }
    }
    closedir($cDir);
}

function collectLexicons($filePath)
{
    global $lexiconFile;
    $content = file_get_contents($filePath);

    $lexiconFileHandler = fopen($lexiconFile,'a');
    preg_match_all("#>[ :;]*([АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяA-Za-z0-9 \[\]!\(\),\.\?\'\"\-\+\n\_]+)[ :;\n\t]*<#ui",$content,$matches);
    array_shift($matches);
    foreach($matches as $match)
    {
        foreach($match as $m)
        {
            $m = trim($m);
            if($m == '') continue;
            if(substr_count($m,'[') == 2 && substr_count($m,']') == 2 && substr($m,0,2) == '[[' && substr($m,-2) == ']]') continue;
            //Сначала проверим, есть ли этот лексикон уже в файле
            $lexicons = file_get_contents($lexiconFile);
            if(stripos($lexicons,'"'.$m.'"') === false && stripos($lexicons,"'".$m."'") === false && $m !== '')
            {
                fwrite($lexiconFileHandler,"\n\$_lang['change_me'] = \"".$m."\";");
            }
        }
    }
    fclose($lexiconFileHandler);
}

processDirectory($chunksDir,'#\.tpl$#i','collectLexicons');
processDirectory($templatesDir,'#\.html$#i','collectLexicons');