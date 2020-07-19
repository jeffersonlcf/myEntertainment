@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card flex-row flex-wrap">
                <div class="card-header border-0 w-25">
                    <img class="card-img-top" src="{{ $me->thumbnail }}">
                </div>
                <div class="card-body">
                    <div class="card-block px-2">
                        <a href="{{ route('me.refresh', ['me' => $me->id]) }}" class="btn-sm btn-primary float-right d-none">Refresh</a>
                        <h5 class="card-title">{{ $me->title . ' (' . trans('me.type.'.$me->type) .')' }} <span class="badge badge-secondary">0</span></h5>
                        <p class="card-text">{{ $me->year }}</p>
                        <like-component url="{{ route('like', ['me' => $me->id]) }}" :initial-like={{ json_encode($like) }}></like-component>
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
                        <li class="list-group-item"><h5>Season {{ $season->season }} <span class="badge badge-success p-2">0</span><h5></li>
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
