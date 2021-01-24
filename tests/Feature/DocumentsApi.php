<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use Tests\TestCase;


class DocumentsApi extends TestCase
{
    /**
     * Получить список документов
     * @return void
     */
    public function testDocumentsList()
    {
        $user_current = User::factory()->create();
        $responseApi = $this->actingAs($user_current,'api')
            ->getJson(route('docs.index'));
        $responseApi->assertStatus(200);
    }

    public function testCreateDocument()
    {
        $user_current = User::factory()->create();

        $data = [
          'title'=>'test api document',
          'description'=>'test description',
          'content'=>'test content api',
          'active'=>true,
        ];

        $response = $this->actingAs($user_current,'api')
            ->postJson(route('docs.store'),$data);

        $response->assertStatus(201)
            ->assertJson([
                'created'=>true
            ]);
    }


    public function testUpdatedDocument()
    {
        $user_current = User::factory()->create();

        $data = [
            'title'=>'test t1'
        ];

        $this->actingAs($user_current,'api')
            ->putJson(route('docs.update',Document::first()->id),$data)
            ->assertStatus(200)
            ->assertJson([
                'updated'=>true
            ]);
    }


}
