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
}
