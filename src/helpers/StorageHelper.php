<?php

namespace nvlad\storage\helpers;

class StorageHelper
{
    public static function saveFile($storage, $file)
    {
        if ($file instanceof \yii\web\UploadedFile) {
            $fileObject = new \nvlad\storage\objects\File($file->tempName);
            $fileObject->file = '0000/'.uniqid().'.'.$file->getExtension();
            if ($storage->save($fileObject)) {
                return $storage->getUrl($fileObject);
            }
            return null;
        }
    }

    public static function saveStream($storage, $resource)
    {

    }

    public static function deleteFile($storage, $filename, $type)
    {
        $file = $filename;
        $obj = $storage->storage->getObject($file, $type);
        $storage->delete($obj);
    }
}
