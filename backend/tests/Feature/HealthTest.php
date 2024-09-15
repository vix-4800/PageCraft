<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_application_is_up(): void
    {
        $this->get('/up')
            ->assertOk()
            ->assertSeeText('Application up');
    }
}
