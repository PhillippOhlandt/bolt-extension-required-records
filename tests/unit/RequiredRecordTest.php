<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Tests;

use Bolt\Extension\Ohlandt\RequiredRecords\Field\Field;
use Bolt\Extension\Ohlandt\RequiredRecords\Record\RequiredRecord;
use Bolt\Tests\BoltUnitTest;

/**
 * Field testing class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class RequiredRecordTest extends BoltUnitTest
{
    /** @test */
    public function it_sets_contenttype_and_fields()
    {
        $record = new RequiredRecord('social', ['title' => 'Twitter', 'slug' => 'twitter']);

        $this->assertEquals('social', $record->getContentType());
        $this->assertCount(2, $record->getFields());
        $this->assertContainsOnlyInstancesOf(Field::class, $record->getFields());
    }

    /** @test */
    public function it_returns_fields_as_array()
    {
        $record = new RequiredRecord('social', ['title' => 'Twitter', 'slug' => 'twitter']);

        $fields = $record->getFieldsArray();
        $this->assertTrue(is_array($fields));
        $this->assertCount(2, $fields);
    }

    /** @test */
    public function it_returns_required_fields_as_array()
    {
        $record = new RequiredRecord('social', ['title|o' => 'Twitter', 'slug' => 'twitter']);

        $fields = $record->getRequiredFieldsArray();
        $this->assertTrue(is_array($fields));
        $this->assertCount(1, $fields);
        $this->assertEquals(['slug' => 'twitter'], $fields);
    }
}
