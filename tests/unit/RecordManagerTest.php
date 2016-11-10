<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Tests;

use Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager;
use Bolt\Extension\Ohlandt\RequiredRecords\Record\RequiredRecord;
use Bolt\Tests\BoltUnitTest;

/**
 * Field testing class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class RecordManagerTest extends BoltUnitTest
{
    /** @test */
    public function it_parses_contenttypes_correctly()
    {
        $contenttypes = [
            'pages' => [
                'name' => 'Pages',
                'singular_name' => 'Page',
                'required' => [
                    [
                        'title' => 'About Us',
                        'slug' => 'about-us'
                    ]
                ]
            ],
            'entries' => [
                'name' => 'Entries',
                'singular_name' => 'Entry'
            ],
            'social' => [
                'name' => 'Social Media',
                'singular_name' => 'Social Media',
                'required' => [
                    [
                        'title' => 'Twitter',
                        'slug' => 'twitter'
                    ],
                    [
                        'title' => 'GitHub',
                        'slug' => 'github'
                    ]
                ]
            ]
        ];

        $app = $this->getApp();

        $manager = new RecordManager($contenttypes, $app['storage']);

        $this->assertCount(3, $manager->getRecords());
        $this->assertContainsOnlyInstancesOf(RequiredRecord::class, $manager->getRecords());
    }

}
