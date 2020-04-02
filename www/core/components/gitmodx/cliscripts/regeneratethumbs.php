#!/usr/bin/php
<?php
define('MODX_API_MODE', true);
//define('XPDO_CLI_MODE',false);
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

ob_end_clean();

$products = $modx->getIterator('msProduct',array(
    'class_key' => 'msProduct'
));
include_once MODX_CORE_PATH.'/model/modx/modprocessor.class.php';
$modx->processors[MODX_CORE_PATH.'components/minishop2/processors/mgr/gallery/generate_multiple.class.php'] = 'msProductFileGenerateMultipleProcessor';
include_once MODX_CORE_PATH.'components/minishop2/processors/mgr/gallery/generate_multiple.class.php';


/* @var msProduct[] $products */
foreach($products as $product)
{
    $modx->log(MODX_LOG_LEVEL_INFO,$product->id);
    $ids = array();

    $productData = $product->getOne('Data');
    /* @var msProduct $product */
    if($productData && $productFiles = $productData->getMany('Files'))
    {
        /* @var msProductFile[] $productFiles */
        foreach($productFiles as $file)
        {
            if($file->get('parent') == 0)
            {
                $ids[] = $file->id;
            }
        }
    }

    $ids = implode(',',$ids);

    $data = array(
        'ids' => $ids,
    );

    if($modx->error && $modx->error->hasError())
    {
        $modx->error->reset();
    }

    /* @var modProcessorResponse $response */
    $response = $modx->runProcessor('mgr/gallery/generate_multiple',$data,array(
        'processors_path' => MODX_CORE_PATH.'components/minishop2/processors/'
    ));

    if($response->response['success'])
    {
        $modx->log(MODX_LOG_LEVEL_INFO,'Успешно сгенерированы превьюшки для товара '.$product->id);
    }
}

exit;