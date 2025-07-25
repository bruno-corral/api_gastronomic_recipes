<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Bruno',
            'email'    => 'bruno@gmail.com',
            'password' => '123456',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'User registered successfully!'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Bruno',
            'email'=> 'bruno@gmail.com',
        ]);
    }

    public function test_login_user(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Bruno',
            'email'    => 'bruno@gmail.com',
            'password' => '123456',
        ]);

        $user = $response->json('user');

        $user['password'] = '123456';

        $responseUserLogged = $this->postJson('/api/login', $user);

        $responseUserLogged->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User logged successfully!'
            ]);  
    }

    public function test_get_user_validated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/validate');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User authenticated!'
            ]);      
    }

    public function test_get_recipes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');
        
        $response = $this->getJson('/api/recipe');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Recipes found successfully.'
            ]);
    }

    public function test_get_one_recipe(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $createResponse = $this->postJson('/api/recipe', [
            'title' => 'Bolo de Fubá',
            'description'=> 'Ingrediente: Milho, Farinha, Manteiga',
        ]);

        $recipeId = $createResponse->json('recipe.id');
        
        $response = $this->getJson("/api/recipe/{$recipeId}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Recipe found successfully.'
            ]);

        $this->assertDatabaseHas('recipes', [
            'title' => 'Bolo de Fubá',
            'description'=> 'Ingrediente: Milho, Farinha, Manteiga',
        ]);
    }

    public function test_post_recipe()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');
        
        $response = $this->postJson('/api/recipe', [
            'title' => 'Torta assada de limão',
            'description'=> 'Ingrediente: Limão, Farinha',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Recipe created successfully.'
            ]);

        $this->assertDatabaseHas('recipes', [
            'title' => 'Torta assada de limão',
            'description'=> 'Ingrediente: Limão, Farinha',
        ]);
    }

    public function test_put_recipe(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $createResponse = $this->postJson('/api/recipe', [
            'title' => 'Torta holandesa',
            'description'=> 'Ingrediente: Chocolate, Farinha, Bolacha',
        ]);

        $recipeId = $createResponse->json('recipe.id');
        
        $updateResponse = $this->putJson("/api/recipe/{$recipeId}", [
            'title' => 'Torta holandesa de Morango',
            'description'=> 'Ingrediente: Morango, Farinha, Bolacha',
        ]);

        $updateResponse->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Recipe updated successfully.'
            ]);;

        $this->assertDatabaseHas('recipes', [
            'title' => 'Torta holandesa de Morango',
            'description'=> 'Ingrediente: Morango, Farinha, Bolacha',
        ]);
    }

    public function test_delete_recipe(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $createResponse = $this->postJson('/api/recipe', [
            'title' => 'Bolo de Limão',
            'description'=> 'Ingrediente: Limão, Farinha, Bolacha',
        ]);

        $recipeId = $createResponse->json('recipe.id');
        
        $deleteResponse = $this->deleteJson("/api/recipe/{$recipeId}");

        $deleteResponse->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Recipe deleted successfully.'
            ]);
    }

    public function test_get_comment_recipe(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $createResponse = $this->postJson('/api/recipe', [
            'title' => 'Bolo de Cenoura',
            'description'=> 'Ingrediente: Cenoura, Farinha, Bolacha',
        ]);

        $recipeId = $createResponse->json('recipe.id');

        $response = $this->postJson("/api/recipe/{$recipeId}/comment", [
            'author' => 'João',
            'comment' => 'Bolo muito bom',
            'note' => 5,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Comment created successfully.'
            ]);
    }
}
