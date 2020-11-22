<?php

namespace Tests\Unit\API\v1\Channel;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function registerRolesAndPermissions()
    {
        if (Role::where('name', config('permission.default_roles')[0])->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        if (Permission::where('name', config('permission.default_permissions')[0])->count() < 1) {
            foreach (config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

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
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $response = $this->actingAs($user)->postJson(route('channel.create'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_can_create()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $response = $this->actingAs($user)->postJson(route('channel.create'), [
            'name' => 'laravel'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_channel_update_should_be_validated()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $response = $this->actingAs($user)->putJson(route('channel.update'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_can_update()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $channel = Channel::factory()->create([
            'name' => 'Laravel'
        ]);

        $response = $this->actingAs($user)->putJson(route('channel.update'), [
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
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $response = $this->actingAs($user)->deleteJson(route('channel.delete'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_can_delete()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $channel = Channel::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('channel.delete'), ['id' => $channel->id]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
