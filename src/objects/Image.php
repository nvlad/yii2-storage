<?php
namespace nvlad\storage\objects;

/**
 *@property $straem
 */
class Image extends File
{
    public function getResizedUrl($width, $height)
    {
        $url = str_replace('/0000/', '/'.$width.'x'.$height.'/', $this->getUrl());
        return $url;
    }
}
