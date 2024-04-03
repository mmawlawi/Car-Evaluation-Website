@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/browse-cars.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js" integrity="sha512-3V8zRVx6wZqdpilMU4EWdHrOkT8U6Ld0Y4lTxLdDdO7331AeVnPfn2Sg0hTRuQ2+3rBTTYzUKcYdEQPCtD4Cog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/browse-cars.js') }}"></script>

@section('content')
<div class="container">
    <h2>Search Results</h2>
    @if($allCars->isEmpty())
        <p>No cars found matching your search criteria.</p>
    @else
        <div class="grid">
            @foreach($allCars as $car)
                <div class="grid-item">
                    <div class="card">
                        <img src="{{ $car->model->photo_link_1 ?? asset('images/default-car.jpg') }}" alt="Car Image">
                        <div class="card-body">
                            <h5>{{ optional($car->model->brand)->name }} {{ optional($car->model)->name }}</h5>
                            <p><strong>Year:</strong> {{ $car->year }}</p>
                            <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                            <a href="{{ url('cars/' . $car->id) }}">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>


@endsection
