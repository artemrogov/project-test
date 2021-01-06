<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;

use Tests\TestCase;

/**
 * простые функциональные тесты
 * Class DocumentsTest
 * @package Tests\Feature
 */
class DocumentsTest extends TestCase
{

    /**
     * Тестирование страницы создания документа.
     * Пользователь входит в систему, затем переходит на страницу создания документа
     * Система перенаправляет пользователя на Страницу формы создания документа
     * A basic feature test example.
     *
     * @return void
     */
    public function testDocumentsCreatePage()
    {
        $user_current = User::factory()->create();
        $response = $this->actingAs($user_current)
            ->get(route('documents.create'));
        $response->assertOk();
    }

    /**
     * Тестирование представления на наличие данных в шаблоне
     */
    public function testNavProfileName()
    {
        $user_current = User::factory()->create();

        $profile = $this->actingAs($user_current)
            ->view('home',['name'=>$user_current->name]);

        $profile->assertSee($user_current->name);
    }


    public function testDashboardLabels()
    {
        $user_current = User::factory()->create();
        $card = $this->actingAs($user_current)->view('home');
        $card->assertSee('Панель управления')
            ->assertSee('Управление Документами');
    }


    /**
     * Страница редактирования документа
     */
    public function testEditPageDocuments()
    {
        $user_current = User::factory()->create();

        $current_document = Document::first();

        $form = $this->actingAs($user_current)
            ->get(route('documents.edit',$current_document->id));

        $form->assertOk();
    }


    /**
     * Создать документ
     */
    public function testCreateDocumentStore()
    {

        $data = [
            'title'=>'Test feature document title',
            'description'=>'Test description',
            'content'=>'Test document content'
        ];

        $user_current = User::factory()->create();

        $response = $this->actingAs($user_current)
            ->post(route('documents.store'),$data);

        $response->assertStatus(302);

    }

    /**
     * Редактирование формы документа и возврат статуса,
     * "документ был обновлен", который содержится в сессионой переменной
     * status
     */
    public function testEditDocumentUpdate()
    {
        $data = [
            'title'=>'Test feature document title',
            'description'=>'Test description',
            'content'=>'Test document content'
        ];

        $user_current = User::factory()->create();

        $doc = Document::first();

        $response = $this->actingAs($user_current)
            ->patch(route('documents.update',$doc->id),$data);

        $response->assertSessionHas('status','Обновлен текущий документ');
    }

}
