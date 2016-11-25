<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords;

use Bolt\Extension\SimpleExtension;
use Pimple;

/**
 * Required Records extension class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class RequiredRecordsExtension extends SimpleExtension
{
    public function getServiceProviders()
    {
        return [
            $this,
            new Provider\RequiredRecordsServiceProvider(),
        ];
    }

    protected function registerNutCommands(Pimple $container)
    {
        return [
            new Nut\ShowCommand($container),
            new Nut\CheckCommand($container),
            new Nut\CreateCommand($container)
        ];
    }

    public function boot(\Silex\Application $app)
    {
        //dump($app['requiredrecords.recordmanager']);
        //dump($app['requiredrecords.recordmanager']->getMissingRecords());
        //dump($app['storage']);
    }
}
