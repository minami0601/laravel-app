@extends('layouts.app')

@section('content')

    <div class="center jumbotron bg-warning">

        <div class="text-center text-white">
            <h1>YouTubeまとめ × SNS</h1>
        </div>

    </div>
    <div class="text-right h4">
        @if(Auth::check())
            {{ Auth::user()->name }}
        @endif
        
    </div>
    @include('commons.tabs',['users'=>$users])
    
    @include('users.users', ['users'=>$users])

@endsection