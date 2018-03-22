<?php

namespace RV\TProto\Buffer;

class Buffer
{
    private $buffer = '';

    /**
     * Add data to buffer
     *
     * @param $data
     */
    public function add($data)
    {
        $this->buffer .= $data;
    }

    /**
     * Find pos of delimiter
     *
     * @param $needle
     * @return bool|int
     */
    public function pos($needle)
    {
        return strpos($this->buffer, $needle);
    }

    /**
     * Flush buffer above $pos and return flushed part
     *
     * @param int $pos
     * @return string
     */
    public function flush($pos = 0)
    {
        if (!$pos) {
            $buffer = $this->buffer;
            $this->buffer = '';
            return $buffer;
        }

        $buffer = substr($this->buffer, 0, $pos);
        $this->buffer = substr($this->buffer, $pos + 1);

        return $buffer;
    }
}