<?php
namespace nvlad\storage\storages;

use nvlad\storage\objects\ObjectAbstract;

abstract class StorageAbstract extends \yii\base\Component
{
    public $container = 'default';

    abstract public function save(ObjectAbstract $object);
}
