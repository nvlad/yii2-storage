<?php
namespace nvlad\storage\storages;

use Yii;
use yii\helpers\FileHelper;
use nvlad\storage\objects\ObjectAbstract;

abstract class StorageAbstract extends \yii\base\Component
{
    public $container = 'default';

    abstract public function save(ObjectAbstract $object);

    public function getUrl(ObjectAbstract $object, $params = null)
    {
        $path = Yii::getAlias($this->baseUrl).DIRECTORY_SEPARATOR.$this->container.DIRECTORY_SEPARATOR.$object->file;
        return FileHelper::normalizePath($path, '/');
    }
}
