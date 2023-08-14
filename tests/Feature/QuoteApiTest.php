<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuoteApiTest extends TestCase
{
    use RefreshDatabase;
    public function testFetchAndStoreQuotes(): void
    {
        $response = $this->get('/api/quotes/fetch');

        $response->assertStatus(200);
    }

    public function testFetchAndStoreQuotesFailed(): void
    {
        $response = $this->get('/api/quotes/fetch');

        $response->assertStatus(200);
    }

    public function testGetQuotes(): void
    {
        $response = $this->get('/api/quotes');

        $response->assertStatus(200);
        $this->assertEquals(5,count($response->json()));
    }
}
