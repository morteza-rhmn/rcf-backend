<?php

namespace Tests\Unit\Http\Controllers\API\V01\Channel;

use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test All Channels List Should Be Accessible
     */
    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->getJson(route('channel.all'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Create Channel
     */
    public function test_channel_creating_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_can_create()
    {
        $response = $this->postJson(route('channel.create'), [
            'name' => 'laravel'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_channel_update_should_be_validated()
    {
        $response = $this->putJson(route('channel.update'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_can_update()
    {
        $channel = Channel::factory()->create([
            'name' => 'Laravel'
        ]);

        $response = $this->putJson(route('channel.update'), [
            'id' => $channel->id,
            'name' => 'VueJs'
        ]);

        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('VueJs', $updatedChannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_deleting_should_be_validated()
    {
        $response = $this->deleteJson(route('channel.delete'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_can_delete()
    {
        $channel = Channel::factory()->create();

        $response = $this->deleteJson(route('channel.delete'), ['id' => $channel->id]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
