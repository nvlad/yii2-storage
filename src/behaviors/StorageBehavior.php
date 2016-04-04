<?php

namespace nvlad\storage\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use nvlad\storage\objects;
use nvlad\storage\helpers\StorageHelper;

class StorageBehavior extends Behavior
{
    public $attribute;
    public $storage;
    public $objectType;
    public $deleteIfEmpty = false;

    private $_savePath;
    private $_publicPath;
    private $_storage;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function init()
    {
        if (!is_array($this->attribute)) {
            $this->attribute = [$this->attribute];
        }
        $this->_storage = Yii::$app->{$this->storage};
    }

    /**
     * @param \yii\base\Event $event
     */
    public function beforeInsert($event)
    {
        foreach ($this->attribute as $i) {
            $tmp = \yii\web\UploadedFile::getInstance($event->sender, $i);
            if ($tmp) {
                $this->deleteFile($event, $i);
                $this->saveFile($event, $tmp, $i);
            }
        }
    }

    /**
     * @param \yii\base\Event $event
     */
    public function beforeUpdate($event)
    {
        foreach ($this->attribute as $i) {
            $file = $event->sender->getAttribute($i);

            $tmp = \yii\web\UploadedFile::getInstance($event->sender, $i);
            if (!is_null($tmp)) {
                $this->deleteFile($event, $i);
                $this->saveFile($event, $tmp, $i);
            } else {
                $event->sender->setAttribute($i, $event->sender->getOldAttribute($i));
            }
//            if (is_null($file)) {
//                $file = \yii\web\UploadedFile::getInstance($event->sender, $i);
//            }
//            if ($file) {
//                if (is_object($file)) {
//                    $this->deleteFile($event, $i);
//                    $this->saveFile($event, $file, $i);
//                } else {
//                    $event->sender->setAttribute($i, $file);
//                }
//            } elseif (!$this->deleteIfEmpty) {
//                $event->sender->setAttribute($i, $event->sender->getOldAttribute($i));
//            }
        }
    }

    /**
     * @param \yii\base\Event $event
     */
    public function beforeDelete($event)
    {
        foreach ($this->attribute as $i) {
            $this->deleteFile($event, $i);
        }
    }

    /**
     * get path for file save
     */
    protected function savePath()
    {
        if ($this->_savePath) {
            return $this->_savePath;
        }

        $this->_savePath = rtrim($this->savePath, '/').'/';
        if (substr($this->savePath, 0, 1) == '@') {
            $this->_savePath = Yii::getAlias($this->_savePath).'/';
        }

        if (!is_dir($this->_savePath)) {
            mkdir($this->_savePath);
        }
        return $this->_savePath;
    }

    protected function publicPath()
    {
        if ($this->_publicPath) {
            return $this->_publicPath;
        }
        $this->_publicPath = rtrim($this->publicPath, '/').'/';
        if (substr($this->_publicPath, 0, 1) == '@') {
            $this->_publicPath == Yii::getAlias($this->_publicPath);
        }
        return $this->_publicPath;
    }

    /**
     * save uploaded file
     *
     * @param strind|\yii\web\UploadedFile $file
     */
    protected function saveFile($event, $file, $attribute)
    {
        $filename = StorageHelper::saveFile($this->_storage, $file);

        if ($filename) {
            $event->sender->setAttribute($attribute, $filename);
        }
//
//        if ($file instanceof \yii\web\UploadedFile) {
//            $fileObject = new \nvlad\storage\objects\Image($file->tempName);
//            $fileObject->file = '0000/'.uniqid().'.'.$file->getExtension();
//            if ($this->_storage->save($fileObject)) {
//                $event->sender->setAttribute($attribute, $this->_storage->getUrl($fileObject));
//            }
//        }
    }

    protected function deleteFile($event, $attribute)
    {
        $file = $event->sender->getOldAttribute($attribute);

        StorageHelper::deleteFile($this->_storage, $file, $this->objectType);
    }
}
