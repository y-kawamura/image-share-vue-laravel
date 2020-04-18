<?php

namespace Tests\Feature;

use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * It should add comments
     *
     * @return void
     */
    public function test_should_add_comments()
    {
        factory(Photo::class)->create();
        $photo = Photo::first();

        $content = 'nice!';

        $response = $this->actingAs($this->user)
            ->json('POST', route('photo.comment', [
                'photo' => $photo->id,
            ]), compact('content'));

        $comments = $photo->comments()->get();

        $response->assertStatus(201)
            ->assertJsonFragment([
                'author' => [
                    'name' => $this->user->name,
                ],
                'content' => $content,
            ]);

        $this->assertEquals(1, $comments->count());
        $this->assertEquals($content, $comments[0]->content);
    }
}
