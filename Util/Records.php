<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Util;


class Records
{
    private $app;

    private $contenttypes;

    private $storage;

    public function __construct($app, array $contenttypes, \Bolt\Storage $storage)
    {
        $this->app = $app;

        $this->contenttypes = $contenttypes;

        $this->storage = $storage;
    }

    public function getRequiredRecords()
    {
        $required = [];

        foreach ($this->contenttypes as $contenttype => $value) {
            if (count($value['required'])) {
                $required[$contenttype] = $value['required'];
            }
        }

        return $required;
    }

    public function getMissingRecords()
    {
        $required = $this->getRequiredRecords();

        $missingRecords = [];

        foreach ($required as $contenttype => $items) {
            foreach ($items as $item) {
                $entries = $this->storage->searchContentType($contenttype, $item);

                $entries = array_values($entries);

                if (!count($entries)) {
                    $missingRecords[$contenttype][] = $item;
                }
            }
        }

        return $missingRecords;
    }

    public function createMissingRecords()
    {
        $missingRecords = $this->getMissingRecords();

        foreach ($missingRecords as $contenttype => $items) {
            foreach ($items as $item) {
                $content = $this->storage->getEmptyContent($contenttype);

                $content->setValues($item);

                $this->storage->saveContent($content);
            }
        }
    }
}

