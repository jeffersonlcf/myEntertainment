<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Season;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function show(Season $season)
    {
        $like = null;
        $emotions = [];
        $stars = 0;
        $user = Auth::user();
        if(isset($user)){
            $ratings = $season->ratings()->where('user_id', $user->id)->first();
            $like = $ratings->like ?? $like;
            $emotions = $ratings->emotions ?? $emotions;
            $stars = $ratings->stars ?? $stars;
        }

        return view('me.season.show', compact('season', 'like', 'emotions', 'stars'));
    }

    public function like(Request $request, Season $season)
    {
        $rating = Rating::updateOrCreate(
            ['rateable_type' => 'season', 'rateable_id' => $season->id, 'user_id' => Auth::user()->id],
            ['like' => $request->like]
        );

        return response()->json([
            'message' => 'success',
            'like' => $rating->like,
        ]);
    }

    public function emotions(Request $request, Season $season)
    {
        $rating = Rating::updateOrCreate(
            ['rateable_type' => 'season', 'rateable_id' => $season->id, 'user_id' => Auth::user()->id],
            ['emotions' => $request->emotions]
        );

        return response()->json([
            'message' => 'success',
            'emotions' => $rating->emotions,
        ]);
    }

    public function stars(Request $request, Season $season)
    {
        $rating = Rating::updateOrCreate(
            ['rateable_type' => 'season', 'rateable_id' => $season->id, 'user_id' => Auth::user()->id],
            ['stars' => $request->stars]
        );

        return response()->json([
            'message' => 'success',
            'stars' => $rating->stars,
        ]);
    }
}
