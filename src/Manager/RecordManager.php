<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Manager;

class RecordManager
{
    public function __construct(array $contenttypes)
    {
        $this->parseContentTypes($contenttypes);
    }

    protected function parseContentTypes(array $contenttypes)
    {

    }
}
