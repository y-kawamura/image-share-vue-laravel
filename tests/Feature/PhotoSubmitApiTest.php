<?php

namespace Tests\Feature;

use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoSubmitApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * It should upload a file
     *
     * @return void
     */
    public function test_should_upload_a_file()
    {
        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->json('POST', route('photo.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        $response->assertStatus(201);

        $photo = Photo::first();

        $this->assertRegExp('/^.{32}$/', $photo->id);

        Storage::cloud()->assertExists($photo->filename);
    }

    /**
     * It should not save a file in case of database error
     *
     * @return void
     */
    public function test_should_not_save_a_file_in_case_of_database_error()
    {
        // raise db error
        Schema::drop('photos');

        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->json('POST', route('photo.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        $response->assertStatus(500);

        $this->assertEquals(0, count(Storage::cloud()->files()));
    }

    /**
     * It should not insert to db in case of file save error
     *
     * @return void
     */
    public function test_should_not_insert_to_db_in_case_of_file_save_error()
    {
        Storage::shouldReceive('cloud')
            ->once()
            ->andReturnNull();

        $response = $this->actingAs($this->user)
            ->json('POST', route('photo.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        $response->assertStatus(500);

        $this->assertEmpty(Photo::all());
    }
}
