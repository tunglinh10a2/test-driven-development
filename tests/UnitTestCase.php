<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class UnitTestCase extends BaseTestCase
{
    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        putenv('DB_DEFAULT=testing');
        $app = require __DIR__.'/../bootstrap/app.php';
        ini_set('memory_limit','4G');
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
