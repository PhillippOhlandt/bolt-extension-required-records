<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Filter;

class GroupedByContentTypesFilter
{
    public static function filter(array $records)
    {
        $data = [];

        foreach ($records as $record) {
            $data[$record->getContentType()][] = $record;
        }

        return $data;
    }
}
