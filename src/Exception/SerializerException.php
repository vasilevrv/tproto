<?php

namespace RV\TProto\Exception;

class SerializerException extends \Exception
{
    /**
     * @param $error
     * @return SerializerException
     */
    public static function serialize($error)
    {
        return new self("Failed to serialize: " . $error);
    }

    /**
     * @param $error
     * @return SerializerException
     */
    public static function deserialize($error)
    {
        return new self("Failed to deserialize: " . $error);
    }
}