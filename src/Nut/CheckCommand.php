<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Nut;

use Pimple;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends BaseCommand
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
            ->setDescription('List all missing records');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $this->app['requiredrecords.recordmanager'];

        $missingRecords = $recordManager->getMissingRecords();

        if (!count($missingRecords)) {
            return $output->writeln('There are no missing records.');
        }

        $output->writeln('The following records are missing:');

        $this->renderRecordsTable($missingRecords, $output);
    }
}
