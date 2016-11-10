<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Nut;

use Bolt\Extension\Ohlandt\RequiredRecords\Filter\GroupedByContentTypesFilter;
use Pimple;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends Command
{
    private $app;

    /**
     * Command constructor
     *
     * @param Pimple $app
     * @param array $config
     */
    public function __construct(Pimple $app)
    {
        parent::__construct();
        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('required-records:check')
            ->setDescription('List all missing records')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $this->app['requiredrecords.recordmanager'];

        $missingRecords = $recordManager->getMissingRecords();

        if(!count($missingRecords)) {
            return $output->writeln('There are no missing records.');
        }

        $output->writeln('The following records are missing:');

        $this->renderRecordsTable($missingRecords, $output);
    }

    private function renderRecordsTable(array $records, $output)
    {
        $formattedRecords = GroupedByContentTypesFilter::filter($records);
        $table = $this->getHelper('table');

        $rows = [];

        $first = true;

        foreach($formattedRecords as $contenttype => $records) {

            if(!$first) {
                $rows[] = new TableSeparator();
            }

            $first = false;

            $rows[] = [new TableCell("<fg=green;options=bold>{$contenttype}</>", array('colspan' => 3))];

            $rows[] = new TableSeparator();

            $rows[] = ['key', 'value', 'optional'];

            foreach($records as $record) {
                $rows[] = new TableSeparator();

                foreach($record->getFields() as $field) {
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
