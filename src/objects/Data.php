<?php
namespace nvlad\storage\objects;

class Data extends ObjectAbstract
{
    private $stream;

    public function __construct($data)
    {
        $this->stream = fopen('php://memory', 'w+');
        fwrite($this->stream, $data);
        rewind($this->stream);
    }

    public function getStream()
    {
        return $this->stream;
    }
}
