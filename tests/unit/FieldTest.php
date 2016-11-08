<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords\Tests;

use Bolt\Extension\Ohlandt\RequiredRecords\Field\Field;
use Bolt\Tests\BoltUnitTest;

/**
 * Field testing class.
 *
 * @author Phillipp Ohlandt <phillipp.ohlandt@googlemail.com>
 */
class FieldTest extends BoltUnitTest
{
    /** @test */
    public function it_parses_key_and_value()
    {
        $field = new Field('slug', 'twitter');

        $this->assertEquals('slug', $field->getKey());
        $this->assertEquals('twitter', $field->getValue());
    }

    /** @test */
    public function it_can_be_required()
    {
        $field = new Field('slug', 'twitter');

        $this->assertEquals(true, $field->isRequired());
    }

    /** @test */
    public function it_can_be_optional()
    {
        $field = new Field('slug|o', 'twitter');

        $this->assertEquals(true, $field->isOptional());
    }

    /** @test */
    public function the_shit_wont_break()
    {
        $field = new Field('slug|yolo', 'twitter');

        $this->assertEquals(false, $field->isOptional());
    }
}
