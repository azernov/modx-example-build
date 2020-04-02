<?php
/**
 * Сниппет для подстановки хэша и .min в зависимости от настроек сайта
 * @var $input
 * @var $options
 * TODO добавьте настройку my_production_server
 */


$noMin = preg_match('#nomin#ui', $options);

$min = $modx->config['my_production_server'] ? '.min' : '';

$content = file_get_contents(MODX_BASE_PATH.ltrim($input,'/'));
$hash = crc32($content);

if(!$noMin && !preg_match('#.min.#iu', $input)){
    $input = preg_replace('#\.(svg|js|css)$#ui',$min.'.$1',$input);
}

return $input.'?v='.$hash;