<?php
namespace nvlad\storage\objects;

class Stream extends ObjectAbstract
{
    private $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    public function getData()
    {
        return $this->stream;
    }
}
