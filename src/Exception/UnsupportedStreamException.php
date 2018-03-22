<?php

namespace RV\TProto\Exception;

class UnsupportedStreamException extends \Exception
{
    public function __construct($class)
    {
        parent::__construct("Unsupported $class stream");
    }
}