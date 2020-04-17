<?php

namespace Tests\Feature;

use App\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhotoDetailApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It should get a photo detail information 
     *
     * @return void
     */
    public function test_should_get_a_photo_detail_information()
    {
        factory(Photo::class)->create();
        $photo = Photo::first();

        $response = $this->json('GET', route('photo.show', [
            'id' => $photo->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $photo->id,
                'url' => $photo->url,
                'owner' => [
                    'name' => $photo->owner->name,
                ]
            ]);
    }
}
