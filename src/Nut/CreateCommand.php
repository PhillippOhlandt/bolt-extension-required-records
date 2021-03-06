<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Nut;

use Pimple;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends BaseCommand
{
    /**
     * @var Pimple
     */
    private $app;

    /**
     * Command constructor
     *
     * @param Pimple $app
     */
    public function __construct(Pimple $app)
    {
        parent::__construct();
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('required-records:create')
            ->setDescription('Create all missing records');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $this->app['requiredrecords.recordmanager'];

        $missingRecords = $recordManager->getMissingRecords();

        if (!count($missingRecords)) {
            return $output->writeln('Nothing to create.');
        }

        $recordManager->createMissingRecords();

        $output->writeln('The following records were created:');

        $this->renderRecordsTable($missingRecords, $output);
    }
}
