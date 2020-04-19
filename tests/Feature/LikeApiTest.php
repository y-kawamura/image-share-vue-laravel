<?php

namespace Tests\Feature;

use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Photo::class)->create();
        $this->photo = Photo::first();
    }

    /**
     * It should add like
     *
     * @return void
     */
    public function test_should_add_like()
    {
        $response = $this->actingAs($this->user)
            ->json('PUT', route('photo.like', [
                'id' => $this->photo->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'photo_id' => $this->photo->id,
            ]);

        $this->assertEquals(1, $this->photo->likes()->count());
    }

    /**
     * It should add like only once
     *
     * @return void
     */
    public function test_should_add_like_only_once()
    {
        $params = ['id' => $this->photo->id];
        $this->actingAs($this->user)
            ->json('PUT', route('photo.like', $params));
        $this->actingAs($this->user)
            ->json('PUT', route('photo.like', $params));

        $this->assertEquals(1, $this->photo->likes()->count());
    }

    /**
     * It should delete like
     *
     * @return void
     */
    public function test_should_delete_like()
    {
        $this->photo->likes()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->json('DELETE', route('photo.like', [
                'id' => $this->photo->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'photo_id' => $this->photo->id,
            ]);

        $this->assertEquals(0, $this->photo->likes()->count());
    }
}
