<?php
/**
 * Плагин для админки. Устанавливает источник файлов для ms2Gallery в зависимости от шаблона ресурса
 * TODO добавьте системную настройку для коректной работы
 */
if ($modx->event->name != 'OnDocFormSave') return;

/* @var modResource $resource */
$template = $resource->get('template');
$sources = $modx->getOption("my_template_media_source");
/**
 * В конфиге настройка my_template_media_source выглядит примерно так:
 * //Связка шаблонов с источником файлов Шаблон => Источник
    'my_template_media_source' => array(
        7 => 5
    ),
 *
 */


if($sources[$template]){ // ставим источник файлов, только если есть в настройках
    $resource->setProperties(array('media_source' => $sources[$template]), 'ms2gallery');
    $resource->save();
}