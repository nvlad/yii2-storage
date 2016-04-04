<?php
namespace nvlad\storage\objects;

/**
 *@property $straem
 */
class Stream extends ObjectAbstract
{
    private $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    public function getStream()
    {
        return $this->stream;
    }
}
