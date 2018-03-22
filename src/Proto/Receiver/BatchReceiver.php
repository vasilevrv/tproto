<?php

namespace RV\TProto\Proto\Receiver;

use RV\TProto\Serializer\SerializerInterface;

class BatchReceiver
{
    private $receiver;
    private $function;
    private $size;
    private $batch = array();

    /**
     * BatchReceiver constructor.
     *
     * @param $stream
     * @param callable $function
     * @param SerializerInterface|null $serializer
     * @param $size
     * @throws \VR\TProto\Exception\UnsupportedStreamException
     */
    public function __construct($stream, callable $function, SerializerInterface $serializer = null, $size = 20)
    {
        $this->receiver = new Receiver($stream, array($this, 'receiver'), $serializer);
        $this->function = $function;
        $this->size = $size;
    }

    /**
     * @throws \VR\TProto\Exception\SerializerException
     */
    public function run()
    {
        $this->receiver->run();
        if (0 < count($this->batch)) {
            $this->calllAndFlush();
        }
    }

    /**
     * @param $data
     * @internal
     */
    public function receiver($data)
    {
        $this->batch[] = $data;
        if (count($this->batch) == $this->size) {
            $this->calllAndFlush();
        }
    }

    /**
     * Call batch and flush
     */
    private function calllAndFlush()
    {
        $function = $this->function;
        $function($this->batch);
        $this->batch = array();
    }
}