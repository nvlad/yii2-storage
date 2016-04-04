<?php

namespace nvlad\storage\objects;

class UploadedFile extends ObjectAbstract
{
    private $_file;

    public function __construct(\yii\web\UploadedFile $f)
    {
        $this->_file = $f;
    }

    public function getStream()
    {
        return fopen($this->_file->tempName, 'r');
    }
}