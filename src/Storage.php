<?php
namespace nvlad\storage;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;

class Storage extends \yii\base\Component
{
    public $storage;

    public function getStorage()
    {
        if(!$this->storage) {
            $this->storage = ['class' => 'nvlad\storage\storages\Local'];
        }
        if(!is_object($this->storage)) {
            $backend = $this->storage;
            $backend['storage'] = $this;
            $this->storage = Yii::createObject($backend);
            if(!($this->storage instanceof \nvlad\storage\storages\StorageAbstract)) {
                throw new InvalidParamException('Invalid Storage');
            }
        }
        return $this->storage;
    }
    public function get($file, $objectType = 'File')
    {
        return Yii::createObject([
            'class' => 'nvlad\storage\types\\'.ucfirst($objectType),
            'storage' => $this,
            'file' => $file,
        ]);
    }
    public function getUrl($path)
    {
        return $this->getBackend()->getUrl($path);
    }
}
