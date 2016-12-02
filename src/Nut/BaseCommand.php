<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Nut;

use Bolt\Extension\Ohlandt\RequiredRecords\Filter\GroupedByContentTypesFilter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

class BaseCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function renderRecordsTable(array $records, $output)
    {
        $formattedRecords = GroupedByContentTypesFilter::filter($records);
        $table = $this->getHelper('table');

        $rows = [];

        $first = true;

        foreach ($formattedRecords as $contenttype => $records) {

            if (!$first) {
                $rows[] = new TableSeparator();
            }

            $first = false;

            $rows[] = [new TableCell("<fg=green;options=bold>{$contenttype}</>", array('colspan' => 3))];

            $rows[] = new TableSeparator();

            $rows[] = ['key', 'value', 'optional'];

            foreach ($records as $record) {
                $rows[] = new TableSeparator();

                foreach ($record->getFields() as $field) {
                    $rows[] = [
                        $field->getKey(),
                        $field->getValue(),
                        $field->isOptional() ? 'x' : ''
                    ];
                }
            }
        }

        $table->setRows($rows);
        $table->render($output);
    }
}
