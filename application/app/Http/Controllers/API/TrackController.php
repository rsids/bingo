<?php

namespace App\Http\Controllers\API;

use App\Models\Track;
use Illuminate\Http\Request;

class TrackController
{
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
        $track->played = $request->get('played');
        $track->save();
    }

}
