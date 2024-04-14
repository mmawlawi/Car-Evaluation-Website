@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/details.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"
    integrity="sha512-3V8zRVx6wZqdpilMU4EWdHrOkT8U6Ld0Y4lTxLdDdO7331AeVnPfn2Sg0hTRuQ2+3rBTTYzUKcYdEQPCtD4Cog=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/browse-cars.js') }}"></script>

@section('content')
    <div class="container">
    <h1>{{ $model }}</h1>
    <div class="car-details">
        <img src="{{ $photo_link ?? asset('images/default-car.jpg') }}" alt="Car Image">
        <div class="car-info">
            <p><strong>Brand:</strong> {{ $brand }}</p>
            <p><strong>Year:</strong> {{ $year }}</p>
            <p><strong>{{ $usedOrNew }} </strong> </p>
            <p><strong>Transmission:</strong> {{ $transmission }}</p>
            <p><strong>Drive Type:</strong> {{ $drive }}</p>
            <p><strong>Fuel Consumption:</strong> {{ $fuelconsumption }}</p>
            <p><strong>Kilometers:</strong> {{ $kilometers }}</p>
            <p><strong>Cylinders:</strong> {{ $cylinders }}</p>
            <p><strong>Body Type:</strong> {{ $body }}</p>
            <p><strong>Fuel Type:</strong> {{ $fuel }}</p>
            <p><strong>Doors:</strong> {{ $doors }}</p>
            <p><strong>Seats:</strong> {{ $seats }}</p>
            <p><strong>Engine Size (L):</strong> {{ $enginesize }}</p>
            <div class="price"><h3><strong>Price:</strong> {{ $price }}</div><h3>
    </div>
        </div>
    </div>
    


@endsection