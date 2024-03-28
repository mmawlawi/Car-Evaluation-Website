@extends('layout')

@section('title', 'Home')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/home.js') }}"></script>
@section('content')
    <div class="container" id="main-content-container">
        <section class="hero">
            <div class="hero-container">
                <h1>Find Your Perfect Car</h1>
                <p style="margin-top: 10px;">Explore top-rated vehicles from leading brands</p>
            </div>
        </section>
        <div class="main-container">
            <div class="car-display-container">
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
                <section class="car-listings">
                    <h2 style="  margin-bottom: 20px;">Featured Listings</h2>
                    <div class="listings-grid" id="listings-grid"> 
                        @foreach($cars as $car)
                            <div class="car-listing">
                                <!-- Display car details and images here -->
                                <img src="{{$car->random_photo }}" alt="Car Image">
                                <h3>{{ $car->year }} {{ $car->model->name }}</h3>
                                <p>Price: {{ $car->price }}</p>
                                <!-- Add more details as needed -->
                            </div>
                        @endforeach </div>
                </section>
            </div>
            <hr class="separator">
            <section id="contact-us-section" class="contact-us">
                <div class="contact-container">
                    <h2>Contact Us</h2>
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection
