@extends('layout')

@section('title', 'Dashboard')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


@section('content')
    
    <div class="main-content container mt-5" style="margin-bottom: 3rem;">
        <div class="content-left">
            <h1 id="username">{{ $user->name }}</h1>
            <div class="user-info">
                <p><strong>E-Mail:</strong> {{ $user->email }}</p>
                @if($user->phone_number == null)
                    <p class="error"><strong>Phone Number:</strong> No Phone Number!</p>
                @else
                    <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                @endif
                <p><strong>Cars Listed:</strong> {{ $nb_cars }}</p>
            </div>

            <div class="buttons">
                <button id = "edit-btn"> Edit Profile </button> 
                <a href="{{ route('logout') }}"><button id = "logout-btn"> Log Out </button></a>
            </div>
        </div>

        <div class="visits-box">
            @if($visits->isEmpty()) 
                <p>No new visits</p>
            @endif
            @foreach ($visits->reverse() as $visit)
                <div class="visit">
                    @if ($visit->visitor_id == 0)
                        <p>Guest {{ $visit->guest_id }} seems interested in your {{ $visit->car->year }} {{ $visit->car->brand->name }} {{ $visit->car->model->name }}</p>
                    @else
                        <p>{{ $visit->visitor->name }} seems interested in your {{ $visit->car->year }} {{ $visit->car->brand->name }} {{ $visit->car->model->name }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    </div>

    
    
    <div id = "edit-modal">
        <div id = "modal-content">
            
        </div>
    </div>
@endsection