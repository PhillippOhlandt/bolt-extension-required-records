<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords;

use Bolt\Extension\Ohlandt\RequiredRecords\Controller\Backend;
use Bolt\Extension\SimpleExtension;
use Bolt\Menu\MenuEntry;
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

    protected function registerTwigPaths()
    {
        return [
            'templates' => ['position' => 'append', 'namespace' => 'RequiredRecords']
        ];
    }

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

    protected function registerBackendControllers()
    {
        return [
            '/' => new Backend(),
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
        parent::boot($app);
    }
}
