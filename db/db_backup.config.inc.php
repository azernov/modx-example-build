<?php
/*******************************************************************************
 * Copyright (c) 2017.
 * Artyom Zernov aka ArtProg
 * info@opencolour.ru
 ******************************************************************************/

include dirname(dirname(__FILE__)).'/www/core/config/config.inc.php';

return array(
    'db_name' => $dbase,
    'db_dsn' => $database_dsn,
    'db_user' => $database_user,
    'db_password' => $database_password,
    'db_options' => $driver_options,

    //Общие параметры подключения
    'options' => array(
        '--user='.$database_user,
        '--password='.$database_password,
        '--extended-insert=FALSE',
        '--dump-date=FALSE',
        '--skip-tz-utc',
    ),

    //Параметры для импорта структуры
    'structureOptions' => array(
        '--skip-opt',
        '--skip-comments',
        '--add-drop-table', # for add DROP TABLE before CREATE TABLE (p.s. NOT USE —compact!)
        '--create-options', # add current AUTO_INCREMENT and other options
        '--routines', # add stored procedures
        '--triggers', # add triggers
        '--no-data', # skip data
    ),

    //Параметры для импорта данных
    'dataOptions' => array(
        '--skip-opt',
        '--skip-comments',
        '--disable-keys', # creating indexes after load data (for acceleration)
        '--replace', # for ignoring double rows and replace existing
        '--skip-triggers',
        '--default-character-set=utf8',
        '--set-charset',
        '--no-create-info', # skip structure
    ),

    //Список таблиц, которые мы игнорируем при экспорте структуры
    'ignoreStructure' => array(
        /*'modx_register_messages',
        'modx_manager_log',
        'modx_register_queues',
        'modx_register_topics',*/
    ),

    //Список таблиц, которые мы игнорируем при экспорте данных
    'ignoreData' => array(
        /*'modx_session',
        'modx_register_messages',
        'modx_manager_log',
        'modx_register_queues',
        'modx_register_topics',*/
    )
);