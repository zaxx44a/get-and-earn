<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;

class PointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_referral_view_should_be_counted()
    {
        $user = User::factory()->create();
        $response = $this->get('/register/' . $user->id);

        $user->refresh();

        $this->assertSame( 1, $user->registration_views);
        $response->assertStatus(200);
    }

    public function test_new_referral_add_5_point()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'password_confirmation' => 'password',
            'phone' => '10',
            'referral_id' => $user->id,
            'avatar' => $file,
        ]);
        $user->refresh();
        $this->assertSame( 5, $user->credit);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_more_than_5_referral_add_7_point()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        for ($i=0; $i < 5; $i++) { 
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => "test$i@example.com",
                'password' => 'password',
                'password_confirmation' => 'password',
                'password_confirmation' => 'password',
                'phone' => "102050$i",
                'referral_id' => $user->id,
                'avatar' => UploadedFile::fake()->image("images$i.jpg"),
            ]);
            $this->post(route('logout'));
        }

        $user->refresh();
        $this->assertSame( 25, $user->credit);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => "test100@example.com",
            'password' => 'password',
            'password_confirmation' => 'password',
            'password_confirmation' => 'password',
            'phone' => "102050100",
            'referral_id' => $user->id,
            'avatar' => UploadedFile::fake()->image("images.jpg"),
        ]);
        $user->refresh();
        $this->assertSame( 32, $user->credit);
    }


    public function test_more_than_11_referral_add_10_point()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        for ($i=0; $i < 11; $i++) { 
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => "test$i@example.com",
                'password' => 'password',
                'password_confirmation' => 'password',
                'password_confirmation' => 'password',
                'phone' => "102050$i",
                'referral_id' => $user->id,
                'avatar' => UploadedFile::fake()->image("images$i.jpg"),
            ]);
            $this->post(route('logout'));
        }

        $user->refresh();
        $this->assertSame( 67, $user->credit);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => "test100@example.com",
            'password' => 'password',
            'password_confirmation' => 'password',
            'password_confirmation' => 'password',
            'phone' => "102050100",
            'referral_id' => $user->id,
            'avatar' => UploadedFile::fake()->image("images.jpg"),
        ]);
        $user->refresh();
        $this->assertSame( 77, $user->credit);
    }
}
