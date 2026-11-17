<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ShipmentMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pickup_form_offers_camera_photo_and_video_uploads(): void
    {
        $this->get(route('shipments.create'))
            ->assertOk()
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="package_photo"', false)
            ->assertSee('accept="image/*"', false)
            ->assertSee('name="package_video"', false)
            ->assertSee('accept="video/*"', false);
    }

    public function test_pickup_request_rejects_non_image_and_non_video_uploads(): void
    {
        $this->post(route('shipments.store'), [
            'package_photo' => UploadedFile::fake()->create('package.txt', 1, 'text/plain'),
            'package_video' => UploadedFile::fake()->create('package.txt', 1, 'text/plain'),
        ])->assertSessionHasErrors(['package_photo', 'package_video']);
    }
}
