<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\RoundResource;
use App\Http\Resources\RoundsResource;
use App\Models\Round;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoundController
{
    public function index()
    {
        return new RoundsResource(Round::orderBy("title")->get());
    }

    public function destroy($id)
    {
        $round = Round::findOrFail($id);
        $round->delete();
        return $this->index();
    }

    public function show($id)
    {
        $round = Round::findOrFail($id);
        RoundResource::withoutWrapping();
        return new RoundResource($round);
    }

    public function store(Request $request)
    {
        $round = Round::create(["title" => $request->get("title")]);
        $tracks = $request->get("tracks");
        collect($tracks)->each(function ($item) use ($round) {
            $track = new Track();
            $track->artist = $item["artist"];
            $track->song = $item["song"];
            $track->round_id = $round->id;
            $track->save();
        });
        return new RoundsResource(Round::orderBy("title")->get());
    }
}
