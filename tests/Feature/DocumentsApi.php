<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentsApi extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDocumentsList()
    {
        $user_current = User::factory()->create();
        $responseApi = $this->actingAs($user_current,'api')->getJson('/api/documents');
        $responseApi->assertStatus(200);
    }
}
