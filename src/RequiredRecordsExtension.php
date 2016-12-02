<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords;

use Bolt\Extension\Ohlandt\RequiredRecords\Controller\Backend;
use Bolt\Extension\SimpleExtension;
use Bolt\Menu\MenuEntry;
use Pimple;
use Silex\Application;

/**
 * Required Records extension class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class RequiredRecordsExtension extends SimpleExtension
{
    /**
     * {@inheritdoc}
     */
    public function getServiceProviders()
    {
        return [
            $this,
            new Provider\RequiredRecordsServiceProvider(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerTwigPaths()
    {
        return [
            'templates' => ['position' => 'append', 'namespace' => 'RequiredRecords']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerMenuEntries()
    {
        $menu = new MenuEntry('required-records', 'required-records');
        $menu->setLabel('Required Records')
            ->setIcon('fa:thumb-tack')
            ->setPermission('dbupdate');

        return [
            $menu,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerBackendControllers()
    {
        return [
            '/' => new Backend(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerNutCommands(Pimple $container)
    {
        return [
            new Nut\ShowCommand($container),
            new Nut\CheckCommand($container),
            new Nut\CreateCommand($container)
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        parent::boot($app);
    }
}
