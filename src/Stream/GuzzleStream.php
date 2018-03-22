<?php

namespace RV\TProto\Stream;

class GuzzleStream implements StreamInterface
{
    private $stream;

    /**
     * GuzzleStream constructor.
     * @param \GuzzleHttp\Stream\StreamInterface $stream
     */
    public function __construct(\GuzzleHttp\Stream\StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @inheritdoc
     */
    public function eof()
    {
        return $this->stream->eof();
    }

    /**
     * @inheritdoc
     */
    public function read($length)
    {
        return $this->stream->read($length);
    }

}