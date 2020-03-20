@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Tournament {{$tournament->id}}</h1>
        </div>
    </div>


    <tournament :tournament='@json($tournament)' :types='@json($types)'></tournament>

@endsection
