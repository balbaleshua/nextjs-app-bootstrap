<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create(['role' => 'Admin']));
    }

    public function test_can_create_article()
    {
        $response = $this->postJson('/api/articles', [
            'title' => 'Test Article',
            'content' => 'This is a test article.',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'title' => 'Test Article',
                         'content' => 'This is a test article.',
                     ],
                 ]);

        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
        ]);
    }

    public function test_can_list_articles()
    {
        Article::factory()->count(3)->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_can_show_article()
    {
        $article = Article::factory()->create();

        $response = $this->getJson('/api/articles/' . $article->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $article->id,
                         'title' => $article->title,
                     ],
                 ]);
    }

    public function test_can_update_article()
    {
        $article = Article::factory()->create();

        $response = $this->putJson('/api/articles/' . $article->id, [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'title' => 'Updated Title',
                     ],
                 ]);

        $this->assertDatabaseHas('articles', [
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_delete_article()
    {
        $article = Article::factory()->create();

        $response = $this->deleteJson('/api/articles/' . $article->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }
}