@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/details.css') }}">
    
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
                    <span class="material-icons">branding_watermark</span>
                    <p><strong>Brand:</strong> {{ $brand }}</p>
                </div>

                
                <div class="card">
                    <span class="material-icons">calendar_today</span>
                    <p><strong>Year:</strong> {{ $year }}</p>
                </div>

                <div class="card">
                    <span class="material-icons">{{ $usedOrNew == 'New' ? 'new_releases' : 'history' }}</span>
                    <p><strong>{{ $usedOrNew }}</strong></p>
                </div>

                <div class="card">
                    <span class="material-icons">settings</span>
                    <p><strong>Transmission:</strong> {{ $transmission }}</p>
                </div>

                <div class="card">
                    <span class="material-icons">drive_eta</span>
                    <p><strong>Drive Type:</strong> {{ $drive }}</p>
                </div>
            
                <!-- Fuel Consumption card -->
                <div class="card">
                    <span class="material-icons">local_gas_station</span>
                    <p><strong>Fuel Consumption:</strong> {{ $fuelconsumption }}</p>
                </div>
                
                <div class="card">
                    <span class="material-icons">directions_car</span>
                    <p><strong>Doors:</strong> {{ $doors }}</p>
                </div>

                
                <div class="card">
                    <span class="material-icons">event_seat</span>
                    <p><strong>Seats:</strong> {{ $seats }}</p>
                </div>

                
                <div class="card">
                    <span class="material-icons">build_circle</span>
                    <p><strong>Engine Size (L):</strong> {{ $enginesize }}</p>
                </div>

                
                <div class="card">
                    <span class="material-icons">speed</span>
                    <p><strong>Kilometers:</strong> {{ $kilometers }} Km</p>
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
            <span class="close-button" style="text-align: right;">&times;</span>
            @if ($sellerName !== 'N/A')
                <h2 style="text-align: center;"><strong>{{ $sellerName }} </strong></h2>
                <div>
                    <a href="mailto:{{ $sellerEmail }}">
                        <button onclick = "copyToClipboard('{{ $sellerEmail }}' , 'email')"
                            class = "contact-seller-action">Email</button>
                    </a>
                    @if($sellerPhone)
                        <a href="tel:{{ $sellerPhone }}">
                            <button onclick = "copyToClipboard('{{ $sellerPhone }}' , 'phone')"
                                class = "contact-seller-action">Call</button>
                        </a>
                    @else
                    <button class = "contact-seller-action-disabled">Call</button>
                    @endif
                    <p id = "copy-message" style = "display: none;"></p>
                </div>
            @else
                <p>This car does not currently have a seller listed.</p>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text, type) {
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
