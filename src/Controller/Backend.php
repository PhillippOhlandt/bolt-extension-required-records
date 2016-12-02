<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Controller;

use Bolt\Controller\Zone;
use Bolt\Extension\Ohlandt\RequiredRecords\Filter\GroupedByContentTypesFilter;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Backend implements ControllerProviderInterface
{
    /**
     * Controller constructor
     *
     * @param array $config
     */
    public function __construct()
    {
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        /** @var $ctr ControllerCollection */
        $ctr = $app['controllers_factory'];
        $ctr->value(Zone::KEY, Zone::BACKEND);

        $ctr->match('/extend/required-records', [$this, 'overview'])
            ->bind('requiredRecordsOverview')
            ->method(Request::METHOD_GET);
        $ctr->match('/extend/required-records/add', [$this, 'add'])
            ->bind('requiredRecordsAdd')
            ->method(Request::METHOD_GET);

        $ctr->before([$this, 'before']);

        return $ctr;
    }

    public function before(Request $request, Application $app)
    {
        $user = $app['users']->getCurrentUser();

        if ($user) {
            return null;
        }

        /** @var UrlGeneratorInterface $generator */
        $generator = $app['url_generator'];
        return new RedirectResponse($generator->generate('dashboard'), Response::HTTP_SEE_OTHER);
    }

    public function overview(Request $request, Application $app)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $app['requiredrecords.recordmanager'];
        $requiredRecords = $recordManager->getRecords();
        $missingRecords = $recordManager->getMissingRecords();

        $groupedRecords = GroupedByContentTypesFilter::filter($requiredRecords);

        $records = [];

        foreach ($groupedRecords as $contenttype => $r) {
            foreach ($r as $record) {
                $data = [
                    'data' => $record,
                    'isMissing' => in_array($record, $missingRecords)
                ];
                $records[$contenttype][] = $data;
            }
        }

        return $app['twig']->render('@RequiredRecords/required-records.twig',
            [
                'records' => $records
            ]
        );
    }

    public function add(Request $request, Application $app)
    {
        /** @var $recordManager \Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager */
        $recordManager = $app['requiredrecords.recordmanager'];

        $recordManager->createMissingRecords();

        $app['logger.flash']->success("Missing records were successfully created!");

        return new RedirectResponse($app['url_generator']->generate('requiredRecordsOverview'));
    }
}
