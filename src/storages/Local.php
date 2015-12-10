<?php
namespace nvlad\storage\storages;

use Yii;
use nvlad\storage\objects\ObjectAbstract;
use yii\helpers\FileHelper;

class Local extends StorageAbstract
{
    public $basePath = '@webroot/storage';
    public $baseUrl = '@web/storage';

    private function filePath($file)
    {
        $path = Yii::getAlias($this->basePath).DIRECTORY_SEPARATOR.$this->container.DIRECTORY_SEPARATOR.$file;
        $path = FileHelper::normalizePath($path);

        return $path;
    }

    private function checkPath($path)
    {
        return is_dir($path);
    }

    public function save(ObjectAbstract $object)
    {
        $path = $this->getPath($object->file);
        if (!$this->checkPath($path)) {
            FileHelper::createDirectory($path);
        }

        file_put_contents($file, $object->data);
    }
}
