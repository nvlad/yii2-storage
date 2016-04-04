<?php
namespace nvlad\storage\objects;

class File extends ObjectAbstract
{
    private $filePath;

    public function __construct($path)
    {
        $this->filePath = $path;
    }

    public function getStream()
    {
        return fopen($this->filePath, 'r');
    }
}
