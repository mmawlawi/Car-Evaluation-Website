<script src="{{ asset('js/header.js') }}"></script>
<header>
    <nav class="container">
        <a class="logo" href="{{ route('home') }}">
            <span>CAR</span>
            <span>VO</span>
            <span>LU</span>
            <span>TI</span>
            <span>ON</span>
        </a>
        <div class="nav-toggle"><span></span></div>
        <form action="{{ route('search-cars') }}" method="get" id="searchform">
            @csrf
            <input name="query" type="text" placeholder="Search for a car...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <ul id="menu">
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('browse-cars') }}">Browse Cars</a></li>
            <li><a href="{{ route('sell-your-car') }}">Sell Your Car</a></li>
            <li><a id="contact-us" href="{{ route('home') }}#contact-us-section">Contact Us</a></li>
            @auth
                <li><a href="{{ route('my-cars') }}">My Cars</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @endauth
            @guest
                <li><a href="/register">Register</a></li>
                <li><a href="/login">Login</a></li>
            @endguest
        </ul>
    </nav>
</header>
