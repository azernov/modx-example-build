#!/usr/bin/php
<?php

$templatesDir = dirname(dirname(__FILE__)).'/elements/templates';
$chunksDir = dirname(dirname(__FILE__)).'/elements/chunks';

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
            echo 'Ищем вхождения чанка '.$filename."\n";
            $fileFunction($dirname.'/'.$filename);
        }
    }
    closedir($cDir);
}

function processChunkFunction($filePath)
{
    global $templatesDir;
    $chunkName = end(explode('/',$filePath));
    $tmp = explode('.',$chunkName);
    if(count($tmp) > 1)
    {
        array_pop($tmp);
    }
    $chunkName = implode('.',$tmp);
    $chunkPlaceholder = "{include '".$chunkName."'}";
    $chunkContent = file_get_contents($filePath);

    $tDir = opendir($templatesDir);
    while($tFile = readdir($tDir))
    {
        if($tFile != '.' && $tFile != '..')
        {
            echo 'Открываю файл '.$tFile."\n";
            $content = file_get_contents($templatesDir.'/'.$tFile);
            $content = str_replace($chunkContent,$chunkPlaceholder,$content);
            file_put_contents($templatesDir.'/'.$tFile,$content);
        }
    }
    closedir($tDir);
}

processDirectory($chunksDir,'#\.tpl$#i','processChunkFunction');