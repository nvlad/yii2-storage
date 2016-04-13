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

    private function checkPath($file)
    {
        return is_dir(dirname($file));
    }

    public function save(ObjectAbstract $object)
    {
        $path = $this->filePath($object->file);
        if (!$this->checkPath($path)) {
            FileHelper::createDirectory(dirname($path));
        }

        $stream = $object->stream;
        $fh = fopen($path, 'a');
        $result = stream_copy_to_stream($stream, $fh);
        fclose($fh);

        return $result;
    }

    public function delete(ObjectAbstract $object)
    {
        $path = $this->filePath($object->file);

        if (is_file($path)) {
            return unlink($path);
        }

        return false;
    }

    public function size(ObjectAbstract $object)
    {
        $path = $this->filePath($object->file);

        if (is_file($path)) {
            return filesize($path);
        }
        return -1;
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
        if (is_file($path)) {
            $obj = new $objectType($path);
            $obj->storage = $this;
            $obj->file = $tmp;
            return $obj;
        }
        return null;
    }
}
