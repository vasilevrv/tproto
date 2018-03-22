<?php

namespace RV\TProto\Stream;

use RV\TProto\Exception\UnsupportedStreamException;

class StreamFactory
{
    private function __construct()
    {
    }

    /**
     * @param $stream
     * @return StreamInterface
     * @throws UnsupportedStreamException
     */
    public static function create($stream)
    {
        if ($stream instanceof \GuzzleHttp\Stream\StreamInterface) {
            return new GuzzleStream($stream);
        }

        throw new UnsupportedStreamException(get_class($stream));
    }
}