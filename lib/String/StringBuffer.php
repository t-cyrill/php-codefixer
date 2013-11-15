<?php
namespace CodeFixer\String;

class StringBuffer implements \Countable
{
    private $buffer = '';

    public function append($string) {
        $this->buffer .= $string;
    }

    public function count() {
        return count($this->buffer);
    }

    public function rtrim($charlist = " \t\n\r\0\x0B") {
        $this->buffer = rtrim($this->buffer, $charlist);
    }

    public function __tostring() {
        return $this->buffer;
    }
}
