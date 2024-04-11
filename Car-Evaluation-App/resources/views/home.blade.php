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
                <section class="car-listings">
                    <h2 id="featuredListing">Featured Listings</h2>
                    <div class="listings-grid" id="listings-grid"> 
                        @foreach($cars as $car)
                            <div class="car-item">
                                <div class="car-details">
                                    <h3 id="CarNameText">{{ $car->year }} {{ $car->brand }} {{ $car->model->name }}</h3>
                                    <div class="car-image">
                                        <img src="{{$car->random_photo }}" alt="Car Image">
                                        <div class="overlay"></div>
                                    </div>
                                    <div class="car-details-footer">
                                        <p class="car-kilometers">Miles: {{ $car->kilometers }}</p>
                                        <p class="car-price">Price: ${{ number_format($car->price, 2) }}</p>
                                    </div>
                                </div>
                                <div class="discover-car-btn-div">
                                    <button class="discover-car-btn">Discover Car</button>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    
                </section>
                <hr class="separator">
                <section id="testimonials-section" class="testimonials">
                    <div class="container">
                        <h2>What Our Customers Say</h2>
                        <div class="testimonials-slider">
                            <div class="testimonial-item">
                                <p class="testimonial-text">"I had an amazing experience purchasing my new car through <em>CarVolution</em>. The staff was incredibly helpful, and the process was seamless and efficient. Highly recommend!"</p>
                                <h3 class="customer-name">- John Doe</h3>
                            </div>
                            <div class="testimonial-item">
                                <p class="testimonial-text">"Finding my dream car was a breeze thanks to the fantastic team at <em>CarVolution</em>. Their attention to detail and customer service was beyond my expectations."</p>
                                <h3 class="customer-name">- Jane Smith</h3>
                            </div>
                            <div class="testimonial-item">
                                <p class="testimonial-text">"The selection and pricing at <em>CarVolution</em> were unmatched. I felt valued as a customer and am thrilled with my purchase."</p>
                                <h3 class="customer-name">- Alex Johnson</h3>
                            </div>
                        </div>
                    </div>
                </section>
                
                
            </div>
            <hr class="separator" id="separator-after-testimonials">
            <section id="contact-us-section" class="contact-us">
                <div class="contact-container">
                    <h2>Contact Us</h2>
                    <form action="{{ route('send-mail') }}" method="POST">
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
