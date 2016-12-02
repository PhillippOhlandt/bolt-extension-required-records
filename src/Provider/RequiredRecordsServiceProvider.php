<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Provider;

use Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RequiredRecordsServiceProvider implements ServiceProviderInterface
{
    /**
     * Service Provider Constructor
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $this->registerRecordManager($app);
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * Register RecordManager in application container
     *
     * @param Application $app
     */
    private function registerRecordManager(Application $app)
    {
        $app['requiredrecords.recordmanager'] = $app->share(
            function () use ($app) {
                return new RecordManager(
                    $app['config']->get('contenttypes', 'default'),
                    $app['storage']
                );
            }
        );
    }
}
