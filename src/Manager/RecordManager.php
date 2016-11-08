<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Manager;

use Bolt\Extension\Ohlandt\RequiredRecords\Record\RequiredRecord;

class RecordManager
{
    protected $records = [];

    public function __construct(array $contenttypes)
    {
        $this->parseContentTypes($contenttypes);
    }

    protected function parseContentTypes(array $contenttypes)
    {
        foreach($contenttypes as $contenttype => $values) {
            if (isset($values['required']) && is_array($values['required'])) {
                foreach($values['required'] as $fields) {
                    $record = new RequiredRecord($contenttype, $fields);
                    $this->records[] = $record;
                }
            }
        }
    }
}
