<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $connection = config('database.default');
        if ($connection !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
            throw new \RuntimeException('Tests require isolated SQLite :memory:; refusing persistent database.');
        }

        // Each test application gets an empty in-memory connection; no reset or refresh.
        $this->artisan('migrate', ['--force' => true]);
    }
}
