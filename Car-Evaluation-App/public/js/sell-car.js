function showOtherField(selectId, otherFieldId) {
    const select = document.getElementById(selectId);
    const otherField = document.getElementById(otherFieldId);
    if (select.value === 'other') {
        otherField.style.display = '';
    } else {
        otherField.style.display = 'none';
    }
}


function updateModels() {
    var brand_id = document.getElementById('brand').value;
    var select = document.getElementById('model');
    var options = select.getElementsByTagName('option');
    console.log(brand_id);
    first = true;
    for (var i = 0; i < options.length; i++) {
        var model = options[i];
        var model_brand_id = model.getAttribute('brand_id');
        console.log(brand_id + " " + model_brand_id);
        if (brand_id === model_brand_id || model_brand_id === 'Other') {
            model.style.display = 'block';
            if (first) {
                model.selected = true;
                first = false;
            }
        } else {
            model.style.display = 'none';
        }

        showOtherField('model', 'other_model');
    }


}

function calculateCarAge() {
    const yearInput = document.getElementById('year');
    const carAgeInput = document.getElementById('car_age');
    const yearError = document.getElementById('year_error');
    const year = parseInt(yearInput.value);
    const currentYear = new Date().getFullYear();

    if (year && year <= currentYear && year >= 1886) {
        const age = currentYear - year;
        carAgeInput.value = age;
        yearError.style.display = 'none';
        yearError.textContent = '';
    } else if (yearInput.value !== '') {
        yearError.textContent = 'Please enter a valid year between 1886 and ' + currentYear + '.';
        yearError.style.display = 'block';
        carAgeInput.value = '';
    } else {
        yearError.style.display = 'none';
        yearError.textContent = '';
        carAgeInput.value = '';
    }
}

function validateDoorsAndSeats() {
    const doorsInput = document.getElementById('doors');
    const seatsInput = document.getElementById('seats');
    const doorsError = document.getElementById('doors_error');
    const seatsError = document.getElementById('seats_error');

    const doors = parseInt(doorsInput.value);
    const seats = parseInt(seatsInput.value);

    if (doors < 1 || doors > 5) {
        doorsError.textContent = 'Doors must be between 1 and 5.';
        doorsError.style.display = 'block';
    } else {
        doorsError.style.display = 'none';
        doorsError.textContent = '';
    }

    if (seats < 1 || seats > 22) {
        seatsError.textContent = 'Seats must be between 1 and 22.';
        seatsError.style.display = 'block';
    } else {
        seatsError.style.display = 'none';
        seatsError.textContent = '';
    }
}

function validateCylinders(){
    const cylindersInput = document.getElementById('cylinders');
    const cylindersError = document.getElementById('cylinders_error');

    const cylinders = parseInt(cylindersInput.value);

    if (cylinders < 1 || cylinders > 12) {
        cylindersError.textContent = 'Cylinders must be between 1 and 12.';
        cylindersError.style.display = 'block';
    } else {
        cylindersError.style.display = 'none';
        cylindersError.textContent = '';
    }
}

function validateEngineFuelKm() {
    const engineInput = document.getElementById('engine_l');
    const fuelInput = document.getElementById('fuelconsumption');
    const kmInput = document.getElementById('kilometers');

    const engineError = document.getElementById('engine_l_error');
    const fuelError = document.getElementById('fuelconsumption_error');
    const kmError = document.getElementById('kilometers_error');

    const engine = parseFloat(engineInput.value);
    const fuel = parseFloat(fuelInput.value);
    const km = parseInt(kmInput.value);

    if (engine < 0.6 || engine > 8.0) {
        engineError.textContent = 'Engine liter must be between 0.6 and 8.0.';
        engineError.style.display = 'block';
    } else {
        engineError.style.display = 'none';
        engineError.textContent = '';
    }

    if (fuel < 3 || fuel > 30) {
        fuelError.textContent = 'Fuel consumption must be between 3 and 30 L/100km.';
        fuelError.style.display = 'block';
    } else {
        fuelError.style.display = 'none';
        fuelError.textContent = '';
    }

    // Assuming no upper limit for kilometers but it should be a positive number
    if (km < 0) {
        kmError.textContent = 'Kilometers must be a positive number.';
        kmError.style.display = 'block';
    } else {
        kmError.style.display = 'none';
        kmError.textContent = '';
    }
}