<?

/**
 * Class bhExport
 * Класс для автоматического и массового переноса документов в смежные контексты
 */
class bhExport
{
    /**
     * @var modX
     */
    protected $_modx;

    public $config = array();

    /* @var Babel $babel */
    protected $babel;

    /* @var ms2Gallery $ms2Gallery */
    protected $ms2Gallery;

    public function __construct(&$modx, $config = array())
    {
        $this->_modx = &$modx;
        //Запоминаем контексты, в которых создаются переводы
        $this->config = array(
            'contexts' => explode(',',$this->_modx->getOption('babel.contextKeys'))
        );
        $this->config = array_merge($this->config,$config);
        $this->initializeBabelProcessors();
    }

    public function initializeProcessor($className,$filePath)
    {
        $this->_modx->processors[$filePath] = $className;
        include_once $filePath;
    }

    protected function initializeBabelProcessors()
    {
        if(empty($this->babel))
        {
            require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
            require_once MODX_CORE_PATH.'model/modx/processors/resource/create.class.php';
            //Инициализируем процессор для последующего вызова
            $this->initializeProcessor('BabelDuplicateResourceProcessor',MODX_CORE_PATH.'components/babel/processors/mgr/resource/duplicate.class.php');
            $this->initializeProcessor('BabelLinkResourceProcessor',MODX_CORE_PATH.'components/babel/processors/mgr/resource/link.class.php');
            $this->babel = $this->_modx->getService('babel','Babel',$this->_modx->getOption('babel.core_path',null,$this->_modx->getOption('core_path').'components/babel/').'model/babel/');
        }
    }

    protected function initializeGalleryProcessors()
    {
        if(empty($this->ms2Gallery))
        {
            require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
            require_once MODX_CORE_PATH.'model/modx/processors/resource/create.class.php';
            //Инициализируем процессор для последующего вызова
            $this->ms2Gallery = $this->_modx->getService('ms2Gallery','ms2Gallery',MODX_CORE_PATH.'components/ms2Gallery/model/ms2Gallery/');
            //$this->initializeProcessor('msResourceFileUploadProcessor',MODX_CORE_PATH.'components/ms2Gallery/processors/mgr/gallery/upload.class.php');
            //$this->initializeProcessor('msResourceFileUpdateProcessor',MODX_CORE_PATH.'components/ms2Gallery/processors/mgr/gallery/update.class.php');

        }
    }

    /**
     * Создать переводы всех дочерних ресурсов только в указанном контексте
     * @param string $context
     * @param int $parent
     * @param int $level
     * @param string $currentContext
     */
    public function createTranslationsForContext($context, $parent = 0, $level = 0, $currentContext = 'web')
    {
        if(!in_array($context,$this->config['contexts']) || $context == $currentContext)
        {
            $this->_modx->log(MODX_LOG_LEVEL_ERROR, 'Контекст ' . $context . ' на найден или указан текущий контекст');
            return;
        }

        $processor = 'mgr/resource/duplicate';

        //Подключаем юзера
        $this->_modx->user = $this->_modx->getObject('modUser',1);

        /* @var modResource[] $resources */
        $resources = $this->_modx->getCollection('modResource',array(
            'context_key' => $currentContext,
            'parent' => $parent
        ));

        if($resources)
        {
            //Делаем обход по дочерним ресурсам рекурсивно, делая переводы
            foreach ($resources as $resource)
            {
                /* @var modResource $resource */

                $linkedResources = $this->babel->getLinkedResources($resource->get('id'));
                if (empty($linkedResources))
                {
                    /* always be sure that the Babel TV is set */
                    $this->babel->initBabelTv($resource);
                }


                if (empty($linkedResources[$context]))
                {
                    $data['context_key'] = $context;
                    $data['id'] = $resource->id;

                    if ($this->_modx->error instanceof modError)
                    {
                        $this->_modx->error->reset();
                    }

                    $response = $this->_modx->runProcessor($processor, $data, array(
                        'processors_path' => MODX_CORE_PATH . 'components/babel/processors/'
                    ));
                    if (!$response->response['success'])
                    {
                        $this->_modx->log(MODX_LOG_LEVEL_ERROR, str_repeat('-', $level) . 'Не могу создать перевод в контексте ' . $context . ' для:' . $resource->pagetitle);
                    }
                    else
                    {
                        $this->_modx->log(MODX_LOG_LEVEL_INFO, str_repeat('-', $level) . 'Создан перевод в контексте ' . $context . ' для:' . $resource->pagetitle);
                        //TODO добавить синхронизацию галерей товара и галерей ресурса
                        $this->createTranslationsForContext($context,$resource->id, $level + 1, $currentContext);
                    }
                }
                else
                {
                    $this->_modx->log(MODX_LOG_LEVEL_INFO, str_repeat('-', $level) . 'Перевод уже есть ' . $context . ' для:' . $resource->pagetitle);
                    $this->createTranslationsForContext($context,$resource->id, $level + 1, $currentContext);
                }

            }
        }
    }


    /**
     * Создать переводы всех дочерних ресурсов во всех контекстах
     * @param int $parent
     * @param int $level
     * @param string $currentContext
     */
    public function createTranslations($parent = 0, $level = 0, $currentContext = 'web')
    {
        //Делаем обход всех контекстов, внутри которых создается перевод
        foreach($this->config['contexts'] as $contextKey)
        {
            if ($contextKey == $currentContext) continue;
            $this->createTranslationsForContext($contextKey, $parent, $level, $currentContext);
        }
    }

    /**
     * Создать перевод ресурса во всех контекстах
     * @param string $context
     * @param int $id
     * @param string $currentContext
     */
    public function createTranslationForContext($context, $id, $currentContext = 'web')
    {
        if(!in_array($context,$this->config['contexts']) || $context == $currentContext)
        {
            $this->_modx->log(MODX_LOG_LEVEL_ERROR, 'Контекст ' . $context . ' на найден или указан текущий контекст');
            return;
        }

        $processor = 'mgr/resource/duplicate';

        //Подключаем юзера
        $this->_modx->user = $this->_modx->getObject('modUser',1);

        /* @var modResource $resource */
        $resource = $this->_modx->getObject('modResource',array(
            'context_key' => $currentContext,
            'id' => $id
        ));

        if($resource)
        {
            /* @var modResource $resource */

            $linkedResources = $this->babel->getLinkedResources($resource->get('id'));
            if(empty($linkedResources)) {
                /* always be sure that the Babel TV is set */
                $this->babel->initBabelTv($resource);
            }


            if (empty($linkedResources[$context]))
            {
                $data['context_key'] = $context;
                $data['id'] = $resource->id;

                if ($this->_modx->error instanceof modError)
                {
                    $this->_modx->error->reset();
                }

                $response = $this->_modx->runProcessor($processor, $data, array(
                    'processors_path' => MODX_CORE_PATH . 'components/babel/processors/'
                ));
                if (!$response->response['success'])
                {
                    $this->_modx->log(MODX_LOG_LEVEL_ERROR, 'Не могу создать перевод в контексте '.$context.' для:' . $resource->pagetitle);
                }
                else{
                    $this->_modx->log(MODX_LOG_LEVEL_INFO, 'Создан перевод в контексте '.$context.' для:' . $resource->pagetitle);
                    //TODO добавить синхронизацию галерей товара и галерей ресурса
                }
            }
        }
    }

    /**
     * Копирует все настройки контекста в смежные контексты
     * @param string $currentContextKey
     * @return bool
     */
    public function copyContextSettings($currentContextKey = 'web')
    {
        /* @var modContext $currentContext */
        if(!$currentContext = $this->_modx->getObject('modContext',array('key' => $currentContextKey))){
            $this->_modx->log(MODX_LOG_LEVEL_ERROR, 'Не могу получить главный контекст ('.$currentContextKey.')');
            return false;
        }

        /* @var modContextSetting[] $currentContextSettings */
        $currentContextSettings = $currentContext->getMany('ContextSettings');

        foreach($this->config['contexts'] as $contextKey)
        {
            if($contextKey == $currentContextKey) continue;
            /* @var modContext $modContext */
            if(!$modContext = $this->_modx->getObject('modContext',array('key' => $contextKey)))
            {
                $this->_modx->log(MODX_LOG_LEVEL_ERROR, 'Не могу получить контекст '.$contextKey);
                continue;
            }

            foreach($currentContextSettings as $currentContextSetting)
            {
                //Проверяем, есть ли такая настройка в текущем провряемом контексте
                if(!$this->_modx->getCount('modContextSetting',array('context_key' => $contextKey, 'key' => $currentContextSetting->key)))
                {
                    //Если нет, то добавляем в массив
                    /* @var modContextSetting $newSetting */
                    $newSetting = $this->_modx->newObject('modContextSetting',$currentContextSetting->toArray());
                    $newSetting->set('key',$currentContextSetting->key);
                    $newSetting->set('context_key',$contextKey);
                    if($newSetting->save())
                    {
                        $this->_modx->log(MODX_LOG_LEVEL_INFO, 'К контексту '.$contextKey.' добавлена настройка '.$currentContextSetting->key);
                    }
                    else
                    {
                        $this->_modx->log(MODX_LOG_LEVEL_ERROR, 'Внимание! Не добавлена настройка '.$currentContextSetting->key.' к контексту '.$contextKey.'!');
                    }
                }
            }
        }

        return true;
    }

    /**
     * Создать перевод ресурса во всех контекстах
     * @param int $id
     * @param string $currentContext
     */
    public function createTranslation($id, $currentContext = 'web')
    {
        //Делаем обход всех контекстов, внутри которых создается перевод
        foreach($this->config['contexts'] as $contextKey)
        {
            if ($contextKey == $currentContext) continue;
            $this->createTranslationForContext($contextKey, $id, $currentContext);
        }
    }
}