<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, WithFaker;

    protected array $linksStructure = [
        'first',
        'last',
        'prev',
        'next',
    ];

    protected array $metaStructure = [
        'current_page',
        'from',
        'last_page',
        'links',
        'path',
        'per_page',
        'to',
        'total',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->seed();

        $this->actingAs(User::find(1)->first());
    }
}
