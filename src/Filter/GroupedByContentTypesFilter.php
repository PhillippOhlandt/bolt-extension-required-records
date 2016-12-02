<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Filter;

class GroupedByContentTypesFilter
{
    /**
     * Groups records based on its ContentType
     *
     * @param array $records
     *
     * @return array
     */
    public static function filter(array $records)
    {
        $data = [];

        foreach ($records as $record) {
            $data[$record->getContentType()][] = $record;
        }

        return $data;
    }
}
