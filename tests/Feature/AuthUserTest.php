<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

class AuthUserTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testAuthUserRedirectsHome()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/home');

        $response->assertOk();
        $this->assertAuthenticated();
    }

    public function testNotAuthUserRedirectsLogin()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function testNotAuthUserRegister(){
        $response = $this->get('/register');

        $response->assertOk();
        $this->assertGuest();
    }

    public function testRegister(){
        $user = [
            'full_name' => 'Dasha',
            'nickname' => 'hangsang',
            'email' => 'levkun.dasha@gmail.com',
            'password' => 'qwertyui',
            'password_confirmation' => 'qwertyui'
        ];
        $response = $this->post('/register', $user);
        $response->assertValid();
        $response->assertRedirect();
    }

    public function testAuthUserMyPageTrue()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/home');

        $response->assertViewHas('myPage');
    }

    public function testLoginPage(){
        $response = $this->get('/login');
        $response->assertOk();
    }

    public function testUnsuccessfulLogin(){
        $response = $this->post('/login', ['email' => 'levkun.dasha@gmail.com', 'password' => 'qwertyui']);
        $response->assertInvalid();
        $response->assertSessionHasErrors();
    }

    public function testSuccessfulLogin(){
        $this->post('/register',[
            'full_name' => 'Dasha',
            'nickname' => 'hangsang',
            'email' => 'levkun.dasha@gmail.com',
            'password' => 'qwertyui',
            'password_confirmation' => 'qwertyui']);
        $this->post('/logout');

        $response = $this->post('/login', ['email' => 'levkun.dasha@gmail.com', 'password' => 'qwertyui']);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
    }

    public function testForgotPassword(){
        $response = $this->get('password/reset');
        $response->assertOk();
    }

    public function testResetLinkEmail(){
        User::factory()->create(['email' => 'levkun.dasha@gmail.com']);
        $response = $this->post('password/email', ['email' => 'levkun.dasha@gmail.com']);
        $response->assertValid();
        $response->assertRedirect();
    }

    public function testResetLinkInvalidEmail(){
        $response = $this->post('password/email', ['email' => 'levkun.dasha@gmail.com']);
        $response->assertInvalid();
        $response->assertSessionHasErrors();
    }
}
