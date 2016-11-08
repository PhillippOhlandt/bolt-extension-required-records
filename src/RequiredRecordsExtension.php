<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords;

use Bolt\Extension\SimpleExtension;

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
}
