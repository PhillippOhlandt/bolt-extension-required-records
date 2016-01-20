<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Command;

use Bolt\Extension\Ohlandt\RequiredRecords\Util\Records;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends Command
{
    private $app;

    public function __construct($app)
    {
        parent::__construct();
        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('required-records:create')
            ->setDescription('Creates all missing records');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contenttypes = $this->app['config']->get('contenttypes', 'default');

        $storage = $this->app['storage'];

        $records = new Records($this->app, $contenttypes, $storage);

        $missingRecords = $records->getMissingRecords();

        if (!$missingRecords) {
            return $output->writeln('Nothing to create.');
        }

        $records->createMissingRecords();

        $output->writeln('The following records were created:');

        $this->renderRecordsTables($missingRecords, $output);
    }

    private function renderRecordsTables($records, $output)
    {
        foreach ($records as $contenttype => $items) {
            $table = $this->getHelper('table');
            $table->setHeaders([$contenttype]);

            $rows = [];

            foreach ($items as $item) {
                $formattedItem = [];

                foreach ($item as $key => $value) {
                    $formattedItem[$key] = $key . ': ' . $value;
                }

                $rows[] = $formattedItem;
            }
            $table->setRows($rows);
            $table->render($output);
        }
    }
}

