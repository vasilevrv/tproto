<?php

namespace RV\TProto\Stream;

interface StreamInterface
{
    /**
     * Returns true if the stream is at the end of the stream.
     *
     * @return bool
     */
    public function eof();

    /**
     * Read data from the stream
     *
     * @param int $length Read up to $length bytes from the object and return them.
     * @return string     Returns the data read from the stream.
     */
    public function read($length);
}