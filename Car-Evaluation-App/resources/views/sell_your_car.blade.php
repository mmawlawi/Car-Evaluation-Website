@extends('layout')

@section('title', 'Sell Your Car')
@section('content')
    <div class="container mt-5">
        <h1>Sell Your Car</h1>
        <form action="{{ route('submit-your-car') }}" method="POST" class="needs-validation">
            @csrf

            <div class="form-group">
                <label for="brand">Brand:</label>
                <select name="brand_id" id="brand" class="form-control" onchange="showOtherField('brand', 'other_brand') ; updateModels()" required> 
                    <option value="" selected></option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" >{{ $brand->name }}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
                <input type="text" name="other_brand" id="other_brand" class="form-control mt-3" style="display:none;"
                    placeholder="Enter brand">
            </div>

            <div class="form-group">
                <label for="model">Model:</label>
                <select name="model_id" id="model" class="form-control"
                    onchange="showOtherField('model', 'other_model')">
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" brand_id = "{{$model->brand_id}}">{{ $model->name }}</option>
                    @endforeach
                    <option value="other" >Other</option>
                </select>
                <input type="text" name="other_model" id="other_model" class="form-control mt-3" style="display:none;"
                    placeholder="Enter model">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="year" class="form-control" min="1886"
                        max="{{ date('Y') }}" oninput="calculateCarAge()"  required>
                    <span id="year_error" class="text-danger"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="car_age">Car Age:</label>
                    <input type="text" id="car_age" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="used_or_new">Condition:</label>
                <select name="used_or_new_id" id="used_or_new" class="form-control"  required>
                    @foreach ($usedOrNews as $usedOrNew)
                        <option value="{{ $usedOrNew->id }}">{{ $usedOrNew->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="state">State:</label>
                <select name="state_id" id="state" class="form-control"
                    onchange="showOtherField('state', 'other_state')">
                    @foreach ($state as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
                <input type="text" name="other_state" id="other_state" class="form-control mt-3" style="display:none;"
                    placeholder="Enter state">
            </div>


            <div class="form-group">
                <label for="transmission">Transmission:</label>
                <select name="transmission_id" id="transmission" class="form-control">
                    @foreach ($transmissions as $transmission)
                        <option value="{{ $transmission->id }}">{{ $transmission->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="drivetype">Drive Type:</label>
                <select name="drivetype_id" id="drivetype" class="form-control">
                    @foreach ($driveTypes as $driveType)
                        <option value="{{ $driveType->id }}">{{ $driveType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fueltype">Fuel Type:</label>
                <select name="fueltype_id" id="fueltype" class="form-control">
                    @foreach ($fuelTypes as $fuelType)
                        <option value="{{ $fuelType->id }}">{{ $fuelType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="bodytype">Body Type:</label>
                <select name="bodytype_id" id="bodytype" class="form-control">
                    @foreach ($bodyTypes as $bodyType)
                        <option value="{{ $bodyType->id }}">{{ $bodyType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="doors">Number of Doors:</label>
                    <input type="number" name="doors" id="doors" class="form-control" min="1" max="5"
                        oninput="validateDoorsAndSeats()">
                    <span id="doors_error" class="text-danger"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="seats">Number of Seats:</label>
                    <input type="number" name="seats" id="seats" class="form-control" min="1"
                        max="11" oninput="validateDoorsAndSeats()">
                    <span id="seats_error" class="text-danger"></span>
                </div>

            </div>

            <div class="form-group">
                <label for="engine_l">Engine Liter:</label>
                <input type="number" step="0.1" name="engine_l" id="engine_l" class="form-control"
                    min="0.6" max="8.0" oninput="validateEngineFuelKm()">
                <span id="engine_l_error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="fuelconsumption">Fuel Consumption (L/100km):</label>
                <input type="number" step="0.1" name="fuelconsumption" id="fuelconsumption" class="form-control"
                    min="3" max="30" oninput="validateEngineFuelKm()">
                <span id="fuelconsumption_error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="kilometers">Kilometers:</label>
                <input type="number" name="kilometers" id="kilometers" class="form-control" min="0"
                    oninput="validateEngineFuelKm()">
                <span id="kilometers_error" class="text-danger"></span>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <script>
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
                    if (brand_id === model_brand_id || brand_id === 'other') {
                        model.style.display = 'block';
                        if (first) {
                            model.selected = true;
                            first = false;
                        }
                    } else {
                        model.style.display = 'none';
                    }
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

                if (seats < 1 || seats > 11) {
                    seatsError.textContent = 'Seats must be between 1 and 11.';
                    seatsError.style.display = 'block';
                } else {
                    seatsError.style.display = 'none';
                    seatsError.textContent = '';
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
        </script>
    </div>
@endsection
