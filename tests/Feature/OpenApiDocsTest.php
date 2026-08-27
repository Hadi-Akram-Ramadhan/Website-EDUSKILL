<?php

namespace Tests\Feature;

use Tests\TestCase;

class OpenApiDocsTest extends TestCase
{
    public function test_can_access_openapi_ui(): void
    {
        $response = $this->get('/docs/api');
        $response->assertStatus(200);
    }

    public function test_can_access_openapi_yaml_spec(): void
    {
        $response = $this->get('/docs/openapi.yaml');
        $response->assertStatus(200)
            ->assertSee('openapi: 3.0.3')
            ->assertSee('Gamified Coding Learning Platform API');
    }
}
