<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords;

use Bolt\Application;
use Bolt\BaseExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Extension extends BaseExtension
{
    public function initialize()
    {
        $this->app['twig.loader.filesystem']->addPath(__DIR__ . '/twig');

        $backendRoot = $this->app['resources']->getUrl('bolt');

        $this->app
            ->get($backendRoot . 'required-records/overview', array($this, 'overviewPage'))
            ->bind('required-records-overview');
        $this->app
            ->get($backendRoot . 'required-records/add', array($this, 'addPage'))
            ->bind('required-records-add');

        $this->addMenuOption('Required Records', $backendRoot . 'required-records/overview', 'fa:thumb-tack');


        $this->addConsoleCommand(new Command\Show($this->app));
        $this->addConsoleCommand(new Command\Check($this->app));
        $this->addConsoleCommand(new Command\Create($this->app));

    }

    public function overviewPage(Request $request)
    {
        if (!$this->app['users']->getCurrentUser()) {
            return new RedirectResponse($this->app['resources']->getUrl('bolt'));
        }

        $contenttypes = $this->app['config']->get('contenttypes', 'default');

        $storage = $this->app['storage'];

        $records = new Util\Records($this->app, $contenttypes, $storage);

        return $this->app['twig']->render('requiredrecords_overview.twig', [
            'requiredRecords' => $records->getRequiredRecords(),
            'missingRecords' => $records->getMissingRecords()
        ]);
    }

    public function addPage(Request $request)
    {
        if (!$this->app['users']->getCurrentUser()) {
            return new RedirectResponse($this->app['resources']->getUrl('bolt'));
        }

        $contenttypes = $this->app['config']->get('contenttypes', 'default');

        $storage = $this->app['storage'];

        $records = new Util\Records($this->app, $contenttypes, $storage);

        $records->createMissingRecords();

        return new RedirectResponse($this->app['resources']->getUrl('bolt') . 'required-records/overview');
    }

    public function getName()
    {
        return "Required Records";
    }
}

