<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Field;

class Field
{
    protected $key;

    protected $value;

    protected $isOptional = false;

    public function __construct($key, $value)
    {
        $this->parseField($key, $value);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isOptional()
    {
        return $this->isOptional;
    }

    public function isRequired()
    {
        return !$this->isOptional;
    }

    protected function parseField($key, $value)
    {
        $key = explode('|', $key);

        $this->key = $key[0];

        if (isset($key[1]) && $key[1] === 'o') {
            $this->isOptional = true;
        }

        $this->value = $value;
    }
}
