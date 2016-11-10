<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Tests;

use Bolt\Extension\Ohlandt\RequiredRecords\Filter\GroupedByContentTypesFilter;
use Bolt\Extension\Ohlandt\RequiredRecords\Manager\RecordManager;
use Bolt\Tests\BoltUnitTest;

/**
 * Field testing class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class GroupedByContentTypesFilterTest extends BoltUnitTest
{
    /** @test */
    public function it_groups_by_contenttype()
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

        $filteredRecords = GroupedByContentTypesFilter::filter($manager->getRecords());

        $this->assertCount(2, $filteredRecords);
        $this->assertCount(1, $filteredRecords['pages']);
        $this->assertCount(2, $filteredRecords['social']);
    }

}
