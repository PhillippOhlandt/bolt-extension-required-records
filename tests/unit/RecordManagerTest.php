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

    /** @test */
    public function it_compares_required_records_with_records_from_the_database()
    {
        $app = $this->getApp();
        $this->addDefaultUser($app);

        $em = $app['storage'];
        $repo = $em->getRepository('blocks');

        $entity1 = $repo->create(['title' => 'Twitter', 'slug' => 'twitter', 'status' => 'published']);
        $entity2 = $repo->create(['title' => 'GitHub', 'slug' => 'github', 'status' => 'published']);
        $entity3 = $repo->create(['title' => 'Facebook something', 'slug' => 'facebook', 'status' => 'published']);
        $entity4 = $repo->create(['title' => 'Facebook', 'slug' => 'facebook-2', 'status' => 'published']);

        $repo->save($entity1);
        $repo->save($entity2);
        $repo->save($entity3);
        $repo->save($entity4);

        $contenttypes = [
            'blocks' => [
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

        $manager = new RecordManager($contenttypes, $app['storage']);

        $missingRecords = $manager->getMissingRecords();
        $this->assertCount(0, $missingRecords);
        $this->assertContainsOnlyInstancesOf(RequiredRecord::class, $missingRecords);

        $contenttypes = [
            'blocks' => [
                'required' => [
                    [
                        'title' => 'Twitter',
                        'slug' => 'twitter'
                    ],
                    [
                        'title' => 'GitHub',
                        'slug' => 'github'
                    ],
                    [
                        'title' => 'Facebook',
                        'slug' => 'facebook'
                    ],
                ]
            ]
        ];

        $manager = new RecordManager($contenttypes, $app['storage']);

        $missingRecords = $manager->getMissingRecords();
        $this->assertCount(1, $missingRecords);
        $this->assertContainsOnlyInstancesOf(RequiredRecord::class, $missingRecords);

        $contenttypes = [
            'blocks' => [
                'required' => [
                    [
                        'title' => 'Twitter',
                        'slug' => 'twitter'
                    ],
                    [
                        'title' => 'GitHub',
                        'slug' => 'github'
                    ],
                    [
                        'title|o' => 'Facebook',
                        'slug' => 'facebook'
                    ],
                ]
            ]
        ];

        $manager = new RecordManager($contenttypes, $app['storage']);

        $missingRecords = $manager->getMissingRecords();
        $this->assertCount(0, $missingRecords);
        $this->assertContainsOnlyInstancesOf(RequiredRecord::class, $missingRecords);

        $this->resetDB();
    }

    /** @test */
    public function it_creates_missing_records()
    {
        $app = $this->getApp();
        $this->addDefaultUser($app);

        $em = $app['storage'];
        $repo = $em->getRepository('blocks');

        $entity1 = $repo->create(['title' => 'Twitter', 'slug' => 'twitter', 'status' => 'published']);
        $repo->save($entity1);

        $contenttypes = [
            'blocks' => [
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

        $manager = new RecordManager($contenttypes, $app['storage']);

        $manager->createMissingRecords();

        $missingRecords = $manager->getMissingRecords();
        $this->assertCount(0, $missingRecords);

        $this->resetDB();
    }

}
