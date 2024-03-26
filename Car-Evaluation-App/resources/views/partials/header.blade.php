<header>
    <nav class="container">
        <a class="logo" href="">
            <span>CAR</span>
            <span>VO</span>
            <span>LU</span>
            <span>TI</span>
            <span>ON</span>
        </a>
        <div class="nav-toggle"><span></span></div>
        <form action="" method="get" id="searchform">
            <input type="text" placeholder="Search for a car...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <ul id="menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Browse Cars</a></li>
            <li><a href="{{ route('sell-your-car') }}">Sell Your Car</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Login</a></li>
        </ul>
    </nav>
</header>
