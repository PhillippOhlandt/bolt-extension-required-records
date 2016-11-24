<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Record;

use Bolt\Extension\Ohlandt\RequiredRecords\Field\Field;

class RequiredRecord
{
    protected $contenttype;

    protected $fields = [];

    public function __construct($contenttype, array $fields)
    {
        $this->contenttype = $contenttype;
        $this->setFields($fields);
    }

    public function getContentType()
    {
        return $this->contenttype;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getFieldsArray()
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $fields[$field->getKey()] = $field->getValue();
        }

        return $fields;
    }

    protected function setFields(array $fields)
    {
        foreach($fields as $key => $value) {
            $field = new Field($key, $value);
            $this->fields[] = $field;
        }
    }
}
