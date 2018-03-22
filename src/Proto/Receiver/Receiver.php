<?php

namespace RV\TProto\Proto\Receiver;

use RV\TProto\Buffer\Buffer;
use RV\TProto\Exception\UnsupportedStreamException;
use RV\TProto\Serializer\JsonSerializer;
use RV\TProto\Serializer\SerializerInterface;
use RV\TProto\Stream\StreamFactory;

class Receiver
{
    private $stream;
    private $function;
    private $serializer;
    private $buffer;

    /**
     * ProtoHandler constructor.
     *
     * @param $stream
     * @param callable $function
     * @param SerializerInterface|null $serializer
     * @throws UnsupportedStreamException
     */
    public function __construct($stream, callable $function, SerializerInterface $serializer = null)
    {
        $this->stream = StreamFactory::create($stream);
        $this->function = $function;
        $this->serializer = $serializer ?: new JsonSerializer();
        $this->buffer = new Buffer();
    }

    /**
     * Run
     *
     * @throws \VR\TProto\Exception\SerializerException
     */
    public function run()
    {
        while (!$this->stream->eof()) {
            $this->buffer->add($this->stream->read(65535));
            $this->parse();
        }
    }

    /**
     * Parse received
     *
     * @throws \VR\TProto\Exception\SerializerException
     */
    private function parse()
    {
        $delimiter = $this->serializer->getDelimiter();
        $pos = $this->buffer->pos($delimiter);
        if (false === $pos) {
            return;
        }

        $buffer = $this->buffer->flush($pos);
        $this->call($buffer);
        $this->parse();
    }

    /**
     * Call user function with buffer
     *
     * @param $buffer
     * @throws \VR\TProto\Exception\SerializerException
     */
    private function call($buffer)
    {
        $update = $this->serializer->deserialize($buffer);
        $function = $this->function;
        $function($update);
    }
}