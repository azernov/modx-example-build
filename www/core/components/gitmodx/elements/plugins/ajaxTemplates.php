<?php
/**
 * Плагин для динамической замены шаблона ресурса, если к нему обращаются через ajax
 * TODO добавить настройку my_ajax_templates
 */
switch ($modx->event->name) {
    case 'OnWebPageInit':
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        if ($isAjax) {
            //Устанавливаем ключ для кэша ajax версии
            $cacheKey = $modx->getOption('cache_resource_key',null,'resource');
            $modx->setOption('cache_resource_key', $cacheKey.'/ajax');
        }
        //Устанавливаем настроку и плейсхолдер
        //к ней может обратиться при необходимости
        //в сниппетах через $modx->getOption('ajax')
        //или в чанке через [[++ajax]]
        $modx->setOption('ajax', $isAjax);
        $modx->setPlaceholder('+ajax', $isAjax);
        break;
    case 'OnLoadWebDocument':
        $id = $modx->resource->get('id');
        if($resource = $modx->getObject('modResource',$id))
        {
            $template = $resource->get('template');

            $templatesArray = $modx->getOption('my_ajax_templates');

            $mobileTmp = $templatesArray[$template] ? $templatesArray[$template] : false;

            if($mobileTmp){
                if ($modx->getOption('ajax')) {
                    $modx->resource->set('template', $mobileTmp);
                }
            }
        }
        break;
}