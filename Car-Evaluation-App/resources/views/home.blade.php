@extends('layout')

@section('title', 'Home')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<script src="{{ asset('js/home.js') }}"></script>

@section('content')
    <div class="container" id="main-content-container">
        <section class="hero">
            <div class="hero-container">
                <h1>Find Your Perfect Car</h1>
                <p>Explore top-rated vehicles from leading brands</p> <!-- Search form can go here -->
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
                            <!-- Add more options for other makes -->
                        </select>
                    </div>
                </aside>
                <section class="car-listings">
                    <h2>Featured Listings</h2>
                    <div class="listings-grid"> <!-- Individual car listings go here -->
                        <div class="car-item" data-make="Toyota"> <!-- Add data-make attribute with the make of the car -->
                            <img src="path/to/car-image.jpg" alt="Car Name">
                            <h3>Car Model Name</h3>
                            <p>Price: $XX,XXX</p>
                        </div> <!-- Repeat for each car listing -->
                    </div>
                </section>
            </div>
            <hr class="separator">
            <section class="contact-us">
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
