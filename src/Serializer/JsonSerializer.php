<?php

namespace RV\TProto\Serializer;

use RV\TProto\Exception\SerializerException;

class JsonSerializer implements SerializerInterface
{
    /**
     * @param mixed $data
     * @return mixed|string
     * @throws SerializerException
     */
    public function serialize($data)
    {
        $data = json_encode($data);
        if (JSON_ERROR_NONE !== ($message = json_last_error())) {
            throw new SerializerException($message);
        }
        return $data;
    }

    /**
     * @param string $data
     * @return mixed|string
     * @throws SerializerException
     */
    public function deserialize($data)
    {
        $data = json_decode($data, true);
        if (JSON_ERROR_NONE !== ($message = json_last_error())) {
            throw new SerializerException($message);
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return "\n";
    }
}