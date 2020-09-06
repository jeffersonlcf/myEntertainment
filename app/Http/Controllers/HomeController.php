<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $last_rated_films = $user->ratings()->whereHasMorph('rateable', ['me'], function (Builder $query) {
            $query->where('type', 1)
            ->whereNotNull('like');
        })
        ->with('rateable')->orderBy('updated_at','desc')->limit(4)->get();

        $last_rated_series = $user->ratings()->whereHasMorph('rateable', ['me'], function (Builder $query) {
            $query->where('type', 2);
        })
        ->with('rateable')->latest()->limit(4)->get();
        
        return view('home', compact('last_rated_films', 'last_rated_series'));
    }
}
