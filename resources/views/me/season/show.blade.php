@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card flex-row flex-wrap">
                <div class="card-header border-0">
                    <img class="card-img-top" src="{{ $season->me->thumbnail }}">
                </div>
                <div class="card-body">
                    <div class="card-block px-2">
                        <h5 class="card-title">Season {{ $season->season }} </h5>
                        <p class="card-text">
                            <a href="{{ route('me.show', ['me' => $season->me->id]) }}">{{ $season->me->title . ' (' . $season->me->year .')' }}</a>
                        </p>
                        @auth
                        <p><like-component url="{{ route('season.like', ['season' => $season->id]) }}" :initial-like={{ json_encode($like) }}></like-component></p>
                        <p><star-rating url="{{ route('season.stars', ['season' => $season->id]) }}" :initial-stars='{{ $stars }}'></star-rating></p>
                        <p><emotions-emoji url="{{ route('season.emotions', ['season' => $season->id]) }}" :initial-emotions='{{ json_encode($emotions) }}'></emotions-emoji-component></p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
