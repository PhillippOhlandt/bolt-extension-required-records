<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Nut;

use Silex\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command
{
    private $app;

    /**
     * Command constructor
     *
     * @param Application $app
     * @param array $config
     */
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('required-records:show')
            ->setDescription('Show all required records')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $this->app['requiredrecords.recordmanager'];

        if(!count($recordManager->getRecords())) {
            return $output->writeln('There are no required records.');
        }

        $output->writeln('The following records are required:');

        $this->renderRecordsTables($recordManager->getRecords(), $output);
    }

    private function renderRecordsTables(array $records, $output)
    {
        foreach($records as $record) {
            $table = $this->getHelper('table');
            $table->setHeaders([$record->getContentType()]);

            $rows = [];
            $rows[] = ['key', 'value', 'optional'];
            $rows[] = new TableSeparator();

            foreach($record->getFields() as $field) {
                $rows[] = [
                    $field->getKey(),
                    $field->getValue(),
                    $field->isOptional() ? 'x' : ''
                ];
            }

            $table->setRows($rows);
            $table->render($output);
        }
    }
}