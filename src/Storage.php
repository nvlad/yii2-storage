<?php
namespace nvlad\storage;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use nvlad\storage\storages\StorageAbstract;
use nvlad\storage\objects\ObjectAbstract;

class Storage extends \yii\base\Component
{
    /** @var StorageAbstract */
    private $storage;

    public function setStorage($value)
    {
        if(!is_object($value)) {
            $storage = $value;
            $this->storage = Yii::createObject($storage);
            if(!($this->storage instanceof StorageAbstract)) {
                throw new InvalidParamException('Invalid Storage');
            }
        }
    }

    public function getStorage()
    {
        if(!$this->storage) {
            $this->storage = ['class' => 'nvlad\storage\storages\Local'];
        }
        $this->setStorage($this->storage);

        return $this->storage;
    }

    public function save(ObjectAbstract $object)
    {
        return $this->storage->save($object);
    }

    public function getUrl(ObjectAbstract $object, $params = null)
    {
        return $this->storage->getUrl($object, $params);
    }
}
