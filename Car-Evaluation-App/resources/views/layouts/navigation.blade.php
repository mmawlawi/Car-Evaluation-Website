@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


@section('content')
    <div id="main-content">
        <h1 id = "username"> {{ $user->name}} </h1>
                
        <div class="visits-box">
            
            @if($visits->isEmpty()) 
                <p> No new visits</p>
            @endif
            @foreach ($visits->reverse() as $visit)
                <div class="visit">
                    @if ($visit->visitor_id == 0)
                        <p> Guest{{$visit->guest_id}} seems intrested in your {{$visit->car->year}} {{$visit->car->brand->name}} {{$visit->car->model->name}}
                    @else
                    <p> {{$visit->visitor->name}} seems intrested in your {{$visit->car->year}} {{$visit->car->brand->name}} {{$visit->car->model->name}}
                    @endif
                </div>
                
            @endforeach
        </div>
        <div class="">
            <button> Edit Profile </button>
            <a href = "{{route('logout')}}"><button> Log Out </button> </a>
        </div>
    </div>
    <div id = "edit-modal">
        
    </div>
@endsection