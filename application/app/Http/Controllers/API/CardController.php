<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CardsResource;
use App\Models\Card;
use App\Models\Email;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;

class CardController
{
    public function byRound(Round $round)
    {
        $cards = $round->cards;
        return new CardsResource($cards);
    }

    public function store(Request $request)
    {
        $email = new Email();
        $email->subject = $request->get("subject");
        $email->body = $request->get("text");
        $email->sent = 0;
        $email->save();

        $group = $request->get("group");
        $users = User::where("user_group", $group)->get();
        $rounds = Round::whereIn("id", $request->get("rounds"))->get();
        $users->each(function ($usr) use ($rounds, $email) {
            $rounds->each(function ($round) use ($usr, $email) {
                $this->generateCard($round, $usr, $email);
            });
        });
    }

    function generateCard($round, $user, $email)
    {
        $result = false;
        while (!$result) {
            try {
                $tracks = $this->generateCardTracks(
                    $round->tracks,
                    $user->track_id
                );
                $tracksString = join(",", $tracks);
                $card = new Card();
                $card->round_id = $round->id;
                $card->user_id = $user->id;
                $card->email_id = $email->id;
                $card->tracks = $tracksString;
                $result = $card->save();
            } catch (\Exception $e) {
                $result = false;
            }
        }
    }

    function generateCardTracks($tracks, $favorite)
    {
        $col = [];
        $size = $tracks->count();
        $hasFavorite = $tracks->contains(function ($val) use ($favorite) {
            return $val->id === $favorite;
        });
        $favoriteSet = false;
        // 5 columns to generate
        for ($i = 0; $i < 5; $i++) {
            $offset = floor($size / 5) * $i;
            $j = 0;
            while ($j < 5) {
                if ($hasFavorite && !$favoriteSet) {
                    $id = $favorite;
                    $favoriteSet = true;
                } else {
                    $num = rand(max(1, $offset), $offset + floor($size / 5));
                    $id = $tracks[$num]->id;
                }
                if (!in_array($id, $col)) {
                    $col[] = $id;
                    $j++;
                }
            }
        }
        asort($col);
        return $col;
    }
}
