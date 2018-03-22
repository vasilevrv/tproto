<?php

namespace RV\TProto\Proto\Transmitter;

use RV\TProto\Serializer\JsonSerializer;
use RV\TProto\Serializer\SerializerInterface;

class Transmitter
{
    private $sender;
    private $serializer;

    /**
     * Transmitter constructor.
     *
     * @param $sender
     * @param SerializerInterface|null $serializer
     */
    public function __construct($sender, SerializerInterface $serializer = null)
    {
        $this->sender = $sender;
        $this->serializer = $serializer ?: new JsonSerializer();
    }

    /**
     * @param $data
     * @throws \VR\TProto\Exception\SerializerException
     */
    public function send($data)
    {
        $data = $this->serializer->serialize($data) . $this->serializer->getDelimiter();
        call_user_func($this->sender, $data);
    }
}