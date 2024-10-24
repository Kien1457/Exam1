<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase{
  use RefreshDatabase;
  public function test_user_can_register(){
    $data = [
      'name' => 'John Smith',
      'email' => 'john@gmail.com',
      'password' => 'abcd1234'
    ];
    $response = $this->postJson('/api/register', $data);

    $response->assertStatus(201);
    $response->assertJson(['message' => 'User created successfully']);
    $this->assertDatabaseHas('users', ['email' => 'john@gmail.com']);
  }
  public function test_user_can_login(){
    $user = User::factory()->create([
      'email' => 'sakura@gmail.com',
      'password' => 'abcd1234'
    ]);
    $response = $this->postJson('/api/login',
      ['email' => 'sakura@gmail.com',
      'password' =>'abcd1234']);
    $response->assertStatus(200);
    $response->assertJson(['message' => 'Login successful']);
  }
}