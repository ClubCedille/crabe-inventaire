<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class HealthCheckTest extends TestCase
{
    /**
     * A basic test
     *
     * @return void
     */
    public function testHealthCheck()
    {
        $this->json('GET', '/health')->seeJson([
            'status' => "healthy",
        ]);

    }
}
