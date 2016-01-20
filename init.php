<?php

namespace Bolt\Extension\Ohlandt\RequiredRecords;

if (isset($app)) {
    $app['extensions']->register(new Extension($app));
}

