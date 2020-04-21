<?php

namespace Tests\Feature;

use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhotoListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It should get photo list
     *
     * @return void
     */
    public function test_should_get_photo_list()
    {
        factory(Photo::class, 5)->create();

        $response = $this->json('GET', route('photo.index'));

        $photos = Photo::with(['owner'])->orderBy('created_at', 'desc')->get();

        $expected_data = $photos->map(fn ($photo) => [
            'id' => $photo->id,
            'url' => $photo->url,
            'owner' => [
                'name' => $photo->owner->name,
            ],
            'liked_by_user' => false,
            'likes_count' => 0,
        ])->all();

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
