<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Field;

class Field
{
    /**
     * @var string
     */
    protected $key;
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @var bool
     */
    protected $isOptional = false;

    /**
     * Field constructor
     *
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->parseField($key, $value);
    }

    /**
     * Gets key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Gets value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Check if field is optional
     *
     * @return bool
     */
    public function isOptional()
    {
        return $this->isOptional;
    }

    /**
     * Check if field is required
     *
     * @return bool
     */
    public function isRequired()
    {
        return !$this->isOptional;
    }

    /**
     * Parses field data and sets internal state
     *
     * @param $key
     * @param $value
     */
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
