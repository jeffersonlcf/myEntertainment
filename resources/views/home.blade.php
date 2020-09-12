@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h2>Your recently rated films</h2>
                    <div class="row mb-3">
                    @foreach ($last_rated_films as $rating)
                        <div class="col-sm-3 d-flex flex-column justify-content-center w-50 mt-2">
                            <a href="{{ route('me.show', ['me' => $rating->rateable->id]) }}">
                                <figure class="figure">
                                    <img src="{{ $rating->rateable->thumbnail }}" class="figure-img img-fluid rounded" alt="{{ $rating->rateable->title }}">
                                    <figcaption class="figure-caption text-center">{{ $rating->rateable->title }}</figcaption>
                                </figure>
                            </a>
                            <like-component class="mt-auto" url="{{ route('me.like', ['me' => $rating->rateable->id]) }}" :initial-like={{ json_encode($rating->like) }}></like-component>
                        </div>
                    @endforeach
                    </div>
                    <h2>Your recently rated series</h2>
                    <div class="row mb-3">
                    @foreach ($last_rated_series as $rating)
                        <div class="col-sm-3 d-flex flex-column justify-content-center w-50 mt-2">
                            <a href="{{ route('me.show', ['me' => $rating->rateable->id]) }}">
                                <figure class="figure">
                                    <img src="{{ $rating->rateable->thumbnail }}" class="figure-img img-fluid rounded" alt="{{ $rating->rateable->title }}">
                                    <figcaption class="figure-caption text-center">{{ $rating->rateable->title }}</figcaption>
                                </figure>
                            </a>
                            <like-component class="mt-auto" url="{{ route('me.like', ['me' => $rating->rateable->id]) }}" :initial-like={{ json_encode($rating->like) }}></like-component>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
