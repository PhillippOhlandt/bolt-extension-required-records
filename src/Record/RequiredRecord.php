<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Record;

use Bolt\Extension\Ohlandt\RequiredRecords\Field\Field;

class RequiredRecord
{
    /**
     * @var string
     */
    protected $contenttype;
    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * RequiredRecord constructor
     *
     * @param $contenttype
     * @param array $fields
     */
    public function __construct($contenttype, array $fields)
    {
        $this->contenttype = $contenttype;
        $this->setFields($fields);
    }

    /**
     * Gets ContentType
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contenttype;
    }

    /**
     * Gets fields
     *
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Gets fields as simple array
     *
     * @return array
     */
    public function getFieldsArray()
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $fields[$field->getKey()] = $field->getValue();
        }

        return $fields;
    }

    /**
     * Gets all required fields as simple array
     *
     * @return array
     */
    public function getRequiredFieldsArray()
    {
        $fields = [];

        foreach ($this->fields as $field) {
            if ($field->isRequired()) {
                $fields[$field->getKey()] = $field->getValue();
            }
        }

        return $fields;
    }

    /**
     * Sets fields from array
     *
     * @param array $fields
     */
    protected function setFields(array $fields)
    {
        foreach ($fields as $key => $value) {
            $field = new Field($key, $value);
            $this->fields[] = $field;
        }
    }
}
