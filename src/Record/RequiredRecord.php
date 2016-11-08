<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Record;

class RequiredRecord
{
    protected $fields = [];

    public function __construct(array $fields)
    {
        $this->parseRecord($fields);
    }

    protected function parseRecord(array $fields)
    {

    }
}
