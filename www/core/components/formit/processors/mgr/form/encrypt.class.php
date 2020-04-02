<?php
/**
 * Get list Forms
 *
 * @package FormIt
 * @subpackage processors
 */
class FormItEncryptProcessor extends modObjectGetListProcessor
{
    public $classKey = 'FormItForm';
    public $languageTopics = array('formit:default');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';

    public function initialize()
    {
        $this->setProperty('limit', 0);
        return parent::initialize();
    }

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->where(array(
            'form' => $this->getProperty('form'),
            'encrypted' => 0
        ));
        return $c;
    }

    public function prepareRow(xPDOObject $object)
    {
        /* only save when encrypt method returns a value */
        $values = $object->encrypt($object->get('values'));
        if ($values) {
            $object->set('encrypted', 1);
            $object->set('encryption_type', 2);
            $object->set('values', $values);
            $object->save();
        }
        $ff = $object->toArray();
        return $ff;
    }
}
return 'FormItEncryptProcessor';
