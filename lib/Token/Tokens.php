<?php

class Tokens {
    private $tokens = array();
    private $position = 0;
    private $count = 0;

    public function current()
    {
        return $this->tokens[$this->key()];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return (($this->position < $this->count) && ($this->position >= 0));
    }

    public function nextToken()
    {
        if ($this->position+1 >= $this->count) {
            return new Token();
        }
        return $this->tokens[$this->position+1];
    }

    public function tokenize($code)
    {
        $tokens_array = token_get_all($code);

        $tokens = array();
        foreach ($tokens_array as $t) {
            $tokens[] = new Token($t);
        }

        $this->tokens = $tokens;
        $this->count = count($this->tokens);
        return true;
    }

    public function count()
    {
        return $this->count;
    }
}
