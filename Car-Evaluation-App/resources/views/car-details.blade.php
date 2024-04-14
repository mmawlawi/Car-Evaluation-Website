@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/details.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<script src="{{ asset('js/car-details.js') }}"></script>

@section('content')
    <div class="container" id="carDetailsContainer">
        <h1 class="model-name">{{ $model }}</h1>
        <div class="car-details">
            <div class="image-container">
                <img src="{{ $photolink ?? asset('images/default-car.jpg') }}" alt="Car Image">
            </div>

            <div class="attributes-grid">
                <div class="card">
                    <i class="fas fa-industry"></i>
                    <p><strong>Brand:</strong> {{ $brand }}</p>
                </div>

                <!-- Year card -->
                <div class="card">
                    <i class="fas fa-calendar-alt"></i>
                    <p><strong>Year:</strong> {{ $year }}</p>
                </div>

                <!-- Condition card -->
                <div class="card">
                    <i class="fas fa-car-side"></i>
                    <p><strong>{{ $usedOrNew }}</strong></p>
                </div>

                <!-- Transmission card -->
                <div class="card">
                    <i class="fas fa-cogs"></i>
                    <p><strong>Transmission:</strong> {{ $transmission }}</p>
                </div>

                <!-- Drive Type card -->
                <div class="card">
                    <i class="fas fa-road"></i>
                    <p><strong>Drive Type:</strong> {{ $drive }}</p>
                </div>

                <!-- Fuel Consumption card -->
                <div class="card">
                    <i class="fas fa-gas-pump"></i>
                    <p><strong>Fuel Consumption:</strong> {{ $fuelconsumption }}</p>
                </div>
                <div class="card">
                    <i class="fas fa-car-door"></i>
                    <p><strong>Doors:</strong> {{ $doors }}</p>
                </div>
                <div class="card">
                    <i class=""></i>
                    <p><strong>Seats:</strong> {{ $seats }}</p>
                </div>
                <div class="card">
                    <i class="fas fa-engine"></i>
                    <p><strong>Engine Size (L):</strong> {{ $enginesize }}</p>
                </div>
               
            </div>
            <div class="price-contact-wrapper">
                <div class="price">
                    <h2>Price: ${{ number_format($price, 2) }}</h2>
                </div>
            
                <button id="contactSellerButton" class="contact-seller-button">Contact Seller</button>
            </div>

        </div>
    </div>
    </div>

    <div id="contactSellerModal" class="modal">
        <div class="modal-content" id="contactSellerModalContent">
            <span class="close-button">&times;</span>
            <h2>Contact Seller</h2>
            @if($sellerName !== 'N/A')
            <p><strong>Name:</strong> {{ $sellerName }}</p>
            <p><strong>Email:</strong> {{ $sellerEmail }}</p>
            <p><strong>Phone:</strong> {{ $sellerPhone }}</p>
            @else
            <p>This car does not currently have a seller listed.</p>
            @endif
        </div>
    </div>
    

@endsection
