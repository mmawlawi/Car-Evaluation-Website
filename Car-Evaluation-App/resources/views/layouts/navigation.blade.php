@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


@section('content')
    <div id="main-content">
        <h1 id = "username"> {{ $user->name}} </h1>
                
        
        <div class="">
            <button> Edit Profile </button>
            <a href = "{{route('logout')}}"><button> Log Out </button> </a>
        </div>
    </div>
    <div id = "edit-modal">
        
    </div>
@endsection