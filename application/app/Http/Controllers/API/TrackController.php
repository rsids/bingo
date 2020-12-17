<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TracksResource;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController
{
    public function index()
    {
        return new TracksResource(
            Track::orderBy("artist")
                ->orderBy("song")
                ->get()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $track = Track::findOrFail($id);
        $track->played = $request->get("played");
        $track->save();
    }
}
