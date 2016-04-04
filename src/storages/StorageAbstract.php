<?php
namespace nvlad\storage\storages;

use Yii;
use yii\helpers\FileHelper;
use nvlad\storage\objects\ObjectAbstract;

abstract class StorageAbstract extends \yii\base\Component
{
    public $container = 'default';
    public $objectType = 'nvlad\storage\objects\File';

    abstract public function save(ObjectAbstract $object);

    public function getUrl(ObjectAbstract $object, $params = null)
    {
        $path = Yii::getAlias($this->baseUrl).DIRECTORY_SEPARATOR.$this->container.DIRECTORY_SEPARATOR.$object->file;
        return FileHelper::normalizePath($path, '/');
    }

    public function getPath(ObjectAbstract $object)
    {

    }

    public function getObject($url, $objectType = null)
    {
        $tmp = FileHelper::normalizePath(Yii::getAlias($this->baseUrl).DIRECTORY_SEPARATOR.$this->container.DIRECTORY_SEPARATOR, '/');
        $tmp = str_replace($tmp, '', $url);
        $path = Yii::getAlias($this->basePath).DIRECTORY_SEPARATOR.$this->container.DIRECTORY_SEPARATOR.$tmp;
        $path = FileHelper::normalizePath($path);
        if (is_null($objectType)) {
            $objectType = $this->objectType;
        } elseif (strpos($objectType, '/') === false) {
            $objectType = 'nvlad\storage\objects\\'.$objectType;
        }
        $obj = new $objectType($path);
        $obj->storage = $this;
        $obj->file = $tmp;
        return $obj;
    }
}
