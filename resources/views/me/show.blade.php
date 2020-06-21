@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card flex-row flex-wrap">
                <div class="card-header border-0 w-25">
                    <img class="card-img-top" src="{{ $me->thumbnail }}">
                </div>
                <div class="card-body">
                <div class="card-block px-2">
                    <h5 class="card-title">{{ $me->title . ' (' . trans('me.type.'.$me->type) .')' }}</h5>
                    <p class="card-text">{{ $me->year }}</p>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
