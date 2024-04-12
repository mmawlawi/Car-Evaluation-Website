@extends('layout')

@section('title', 'Browse Cars')

<link rel="stylesheet" href="{{ asset('css/browse-cars.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"
    integrity="sha512-3V8zRVx6wZqdpilMU4EWdHrOkT8U6Ld0Y4lTxLdDdO7331AeVnPfn2Sg0hTRuQ2+3rBTTYzUKcYdEQPCtD4Cog=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/browse-cars.js') }}"></script>

@section('content')
    <div class="container" id="browseCarsPage">
        <aside class="sidebar">
            <h2>Filter Results</h2>
            <form method="GET" action="/filter-cars" id="filters-form">
                <div class="filter-options">
                    <label for="make-filter" style="font-size: 18px">Make:</label>
                    <select id="make-filter"  name="make_filter" onchange="updateModels()">
                        <option value="">All Makes</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>

                    <label for="model-filter" style="font-size: 18px">Model:</label>
                    <select id="model-filter" name="model_filter" disabled>
                        <option value="">Select Model</option>
                    </select>

                    <label for="year-range" style="font-size: 18px"><strong>Year Range:</strong></label>
                    <span id="year-range-value">{{ $minYear }} - {{ $maxYear }}</span>
                    <input type="range" id="year-min" name="year_min" min="{{ $minYear }}" max="{{ $maxYear }}"
                        value="{{ $minYear }}" oninput="updateYearValue()">
                    <input type="range" id="year-max" name="year_max" min="{{ $minYear }}" max="{{ $maxYear }}"
                        value="{{ $maxYear }}" oninput="updateYearValue()">
                    
                    <label for="price-range" style="font-size: 18px"><strong>Price Range:</strong></label>
                    <span id="price-range-value">${{ $minPrice }} - ${{ $maxPrice }}</span>
                    <input type="range" id="price-min" name="price_min" min="{{ $minPrice }}"
                        max="{{ $maxPrice }}" value="{{ $minPrice }}" step="1000" oninput="updatePriceValue()"> 
                    <input type="range" id="price-max" name="price_max" min="{{ $minPrice }}"
                        max="{{ $maxPrice }}" value="{{ $maxPrice }}" step="1000" oninput="updatePriceValue()">
                    

                    <button type="submit" id="apply-filters-btn">Apply Filters</button>
                </div>
            </form>

        </aside>
        <h2 id="searchResultsText">Search Results</h2>

        @if ($allCars->isEmpty())
            <p>No cars found matching your search criteria.</p>
        @else
            <div class="listings-grid" id="listings-grid">
                @foreach ($allCars as $car)
                    <div class="car-item">
                        <div class="car-details">
                            <h3 id="CarNameText">{{ $car->year }} {{ $car->brand }} {{ $car->model->name }}</h3>
                            <div class="car-image">
                                <img src="{{ $car->model->photo_link_1 ?? asset('images/default-car.jpg') }}"
                                    alt="Car Image"
                                    onerror="this.onerror=null; this.src='{{ asset('images/default-car.jpg') }}';">

                                <div class="overlay"></div>
                            </div>
                            <div class="car-details-footer">
                                <p class="car-kilometers"><strong>Kilometers: </strong>
                                    {{ number_format($car->kilometers, 0, '.', '.') }}
                                </p>
                                <p class="car-price"><strong>Price: </strong> ${{ number_format($car->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="discover-car-btn-div">
                            <button class="discover-car-btn">Discover Car</button>
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
