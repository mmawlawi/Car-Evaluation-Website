@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/browse-cars.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"
    integrity="sha512-3V8zRVx6wZqdpilMU4EWdHrOkT8U6Ld0Y4lTxLdDdO7331AeVnPfn2Sg0hTRuQ2+3rBTTYzUKcYdEQPCtD4Cog=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/browse-cars.js') }}"></script>

@section('content')
    <div class="container">
        <aside class="sidebar">
            <h2>Filter Results</h2>
            <div class="filter-options">
                <label for="make-filter">Make:</label>
                <select id="make-filter">
                    <option value="all">All Makes</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Honda">Honda</option>
                </select>

                <label for="year-filter">Model:</label>
                <select id="year-filter">
                    <option value="all">All Models</option>
                </select>

                <label for="price-filter">Price Range:</label>
                <select id="price-filter">
                    <option value="all">All Prices</option>
                </select>

                <!-- Add more filter options as needed -->

                <button id="apply-filters-btn">Apply Filters</button>
            </div>
        </aside>
        <h2 id="searchResultsText">Search Results</h2>

        @if ($allCars->isEmpty())
            <p>No cars found matching your search criteria.</p>
        @else
            
            <div class="listings-grid" id="listings-grid"> 
                @foreach($allCars as $car)
                    <div class="car-item">
                        <div class="car-details">
                            <h3 id="CarNameText">{{ $car->year }} {{ $car->brand->name }} {{ $car->model->name }}</h3>
                            <div class="car-image">
                                <img src="{{ $car->model->photo_link_1 ?? asset('images/default-car.jpg') }}" alt="Car Image">
                                <div class="overlay"></div>
                            </div>
                            <div class="car-details-footer">
                                <p class="car-kilometers"><strong>Kilometers: </strong> {{number_format($car->kilometers, 0, '.', '.')}}
                                </p>
                                <p class="car-price"><strong>Price: </strong> ${{ number_format($car->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="discover-car-btn-div">
                            <button class="discover-car-btn" onclick="window.location.href = '{{route('cardetails' , $car)}}'">Discover Car</button>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="pagination">
                {{ $allCars->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>


@endsection
