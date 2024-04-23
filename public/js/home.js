
$(document).ready(function () {
    function filterAndDisplayCars() {
        var make = $('#make-filter').val();
        var year = $('#year-filter').val();
        var price = $('#price-filter').val();

        var dummyData = [
            { make: 'Toyota', year: 2020, price: 25000, bodyType: 'SUV', mileage: 20000, transmission: 'Automatic', fuelType: 'Gasoline', color: 'Red', features: ['Sunroof', 'Navigation System'] },
            { make: 'Honda', year: 2018, price: 20000, bodyType: 'Sedan', mileage: 30000, transmission: 'Automatic', fuelType: 'Gasoline', color: 'Blue', features: ['Bluetooth', 'Backup Camera'] },
            { make: 'Honda', year: 2018, price: 20000, bodyType: 'Sedan', mileage: 30000, transmission: 'Automatic', fuelType: 'Gasoline', color: 'Blue', features: ['Bluetooth', 'Backup Camera'] },

            { make: 'Honda', year: 2018, price: 20000, bodyType: 'Sedan', mileage: 30000, transmission: 'Automatic', fuelType: 'Gasoline', color: 'Blue', features: ['Bluetooth', 'Backup Camera'] },

            { make: 'Honda', year: 2018, price: 20000, bodyType: 'Sedan', mileage: 30000, transmission: 'Automatic', fuelType: 'Gasoline', color: 'Blue', features: ['Bluetooth', 'Backup Camera'] },

            { make: 'Honda', year: 2018, price: 20000, bodyType: 'Sedan', mileage: 30000, transmission: 'Automatic', fuelType: 'Gasoline', color: 'Blue', features: ['Bluetooth', 'Backup Camera'] },
            
        ];

        var filteredData = dummyData.filter(function (car) {
            return (make === 'all' || car.make === make) &&
                (year === 'all' || car.year == year) &&
                (price === 'all' || car.price <= parseInt(price));
        });
    }

    filterAndDisplayCars();

    $('#apply-filters-btn').click(function () {
        filterAndDisplayCars();
    });

    const testimonials = $('.testimonial-item');
    let index = -1; 

    function cycleTestimonials() {
        index = (index + 1) % testimonials.length;

        testimonials.stop(true, true).css('opacity', '0').css('display', 'none');
        $(testimonials[index]).css('display', 'block').animate({opacity: 1}, 1000);
    }

    cycleTestimonials();


    setInterval(cycleTestimonials, 5000)
    
});

