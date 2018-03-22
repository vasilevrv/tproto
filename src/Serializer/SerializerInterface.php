<?php

namespace RV\TProto\Serializer;

use RV\TProto\Exception\SerializerException;

interface SerializerInterface
{
    /**
     * Serialize your data to array
     *
     * @param mixed $data
     * @return string
     * @throws SerializerException
     */
    public function serialize($data);

    /**
     * Deserialize your data from array
     *
     * @param string $data
     * @return mixed
     * @throws SerializerException
     */
    public function deserialize($data);
}