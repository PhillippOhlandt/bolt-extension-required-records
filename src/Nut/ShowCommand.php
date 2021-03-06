<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Nut;

use Pimple;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends BaseCommand
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
            ->setName('required-records:show')
            ->setDescription('Show all required records');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $this->app['requiredrecords.recordmanager'];

        if (!count($recordManager->getRecords())) {
            return $output->writeln('There are no required records.');
        }

        $output->writeln('The following records are required:');

        $this->renderRecordsTable($recordManager->getRecords(), $output);
    }
}
