@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card flex-row flex-wrap">
                <div class="card-header border-0">
                    <img class="card-img-top" src="{{ $me->thumbnail }}">
                </div>
                <div class="card-body">
                    <div class="card-block px-2">
                        <a href="{{ route('me.refresh', ['me' => $me->id]) }}" class="btn-sm btn-primary float-right d-none">Refresh</a>
                        <h5 class="card-title">{{ $me->title . ' (' . trans('me.type.'.$me->type) .')' }} </h5>
                        <p class="card-text">{{ $me->year }}</p>
                        @auth
                        <p><like-component url="{{ route('me.like', ['me' => $me->id]) }}" :initial-like={{ json_encode($like) }}></like-component></p>
                        <p><star-rating url="{{ route('me.stars', ['me' => $me->id]) }}" :initial-stars='{{ $stars }}'></star-rating></p>
                        <p><emotions-emoji url="{{ route('me.emotions', ['me' => $me->id]) }}" :initial-emotions='{{ json_encode($emotions) }}'></emotions-emoji-component></p>
                        @endauth
                    </div>
                </div>
            </div>

            @if($me->type === 2)
            <div class="card my-2">
                <div class="card-header">
                    Seasons
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($me->seasons as $season)
                    <a href="{{ route('season.show', ['season' => $season->id]) }}">
                        <li class="list-group-item"><h5>Season {{ $season->season }} <h5></li>
                    </a>
                    @empty
                        <li class="list-group-item">No Seasons Registered. Please <a href="{{ route('me.refresh', ['me' => $me->id]) }}">refresh</a></li>
                    @endforelse
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
