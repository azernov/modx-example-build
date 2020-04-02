#!/usr/bin/php
<?php
define("MODX_API_MODE",true);
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/index.php';
$modx->setLogTarget('ECHO');
$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);

/* @var bhExport $bhExport */
$bhExport = $modx->getService('bhExport','bhExport',MODX_CORE_PATH.'components/babelhelper/model/babelhelper/');

ob_end_clean();

$bhExport->copyContextSettings();
$bhExport->createTranslations(0);