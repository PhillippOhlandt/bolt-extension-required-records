<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Manager;

use Bolt\Extension\Ohlandt\RequiredRecords\Record\RequiredRecord;
use Bolt\Storage\EntityManagerInterface;

class RecordManager
{
    protected $records = [];
    /**
     * @var EntityManagerInterface
     */
    private $storage;

    public function __construct(array $contenttypes, EntityManagerInterface $storage)
    {
        $this->parseContentTypes($contenttypes);
        $this->storage = $storage;
    }

    public function getRecords()
    {
        return $this->records;
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
