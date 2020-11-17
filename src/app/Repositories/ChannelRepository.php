<?php

namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * Get All Channels
     */
    public function all()
    {
        return Channel::all();
    }

    /**
     * Create New Channel
     * @param $name
     */
    public function create($name): void
    {
        Channel::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    /**
     * Update Channel
     * @param $id
     * @param $name
     */
    public function update($id, $name): void
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    /**
     * Delete Channel(s)
     * @param $id
     */
    public function destroy($id)
    {
        Channel::destroy($id);
    }
}
