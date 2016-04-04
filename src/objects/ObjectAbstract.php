<?php
namespace nvlad\storage\objects;

/**
 * @property nvlad\storage\storages\StorageAbstract $storage
 */
abstract class ObjectAbstract extends \yii\base\Component
{
    public $file;

    public $storage;

    abstract public function getStream();

    public function getUrl()
    {
        return $this->storage->getUrl($this);
    }
}
