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
        @if($sellerName !== 'N/A')
        <h2><strong>{{ $sellerName }} </strong></h2>
        <div>
            <a href="mailto:{{ $sellerEmail }}" >
                <button onclick = "copyToClipboard('{{ $sellerEmail }}' , 'email')" class = "contact-seller-action">Email</button>
            </a>
            <a href="tel:{{ $sellerPhone }}" >
                <button onclick = "copyToClipboard('{{ $sellerPhone }}' , 'phone')" class = "contact-seller-action">Call</button>
            </a>
            <p id = "copy-message" style = "display: none;"></p>
        </div>
        @else
        <p>This car does not currently have a seller listed.</p>
        @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text , type) {
            const input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            const messageElement = document.getElementById('copy-message');
            if (type === 'email') {
                messageElement.innerText = 'Email copied to clipboard';
            } else if (type === 'phone') {
                messageElement.innerText = 'Phone number copied to clipboard';
            }
            messageElement.style.display = 'block';
            setTimeout(function() {
                messageElement.style.display = 'none';
            }, 12000);
            }
    </script>
    

@endsection
