#!/usr/bin/php
<?php
define('MODX_API_MODE', true);
//define('XPDO_CLI_MODE',false);
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

ob_end_clean();

$modx->loadClass('msResourceFile',MODX_CORE_PATH.'components/ms2gallery/model/ms2gallery/');

$resourceFiles = $modx->getIterator('msResourceFile',array(
    'parent' => 0
));

include_once MODX_CORE_PATH.'/model/modx/modprocessor.class.php';
$modx->processors[MODX_CORE_PATH.'components/ms2gallery/processors/mgr/gallery/multiple.class.php'] = 'msResourceFileMultipleProcessor';
$modx->processors[MODX_CORE_PATH.'components/ms2gallery/processors/mgr/gallery/generate.class.php'] = 'msResourceFileGenerateProcessor';
include_once MODX_CORE_PATH.'components/ms2gallery/processors/mgr/gallery/multiple.class.php';
include_once MODX_CORE_PATH.'components/ms2gallery/processors/mgr/gallery/generate.class.php';

/* @var msResourceFile[] $resourceFiles */
foreach($resourceFiles as $file)
{
    $modx->log(MODX_LOG_LEVEL_INFO, $file->id);

    $data = array(
        'id' => $file->id,
    );

    if($modx->error && $modx->error->hasError())
    {
        $modx->error->reset();
    }

    /* @var modProcessorResponse $response */
    $response = $modx->runProcessor('mgr/gallery/generate',$data,array(
        'processors_path' => MODX_CORE_PATH.'components/ms2gallery/processors/'
    ));

    if($response->response['success'])
    {
        $modx->log(MODX_LOG_LEVEL_INFO,'Успешно сгенерированы превьюшки для ресура '.$file->resource_id.' - файл '.$file->id);
    }
}




exit;