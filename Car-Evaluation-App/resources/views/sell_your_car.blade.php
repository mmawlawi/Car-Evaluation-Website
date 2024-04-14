@extends('layout')

@section('title', 'Sell Your Car')
<link rel="stylesheet" href="{{ asset('css/sell-car.css') }}">

@section('content')
    <div class="container mt-5">
        <h1>Sell Your Car</h1>
        <form action="{{ route('submit-your-car') }}" method="POST" class="needs-validation">
            @csrf

            <div class="form-group">
                <label for="brand">Brand:</label>
                <select name="brand_id" id="brand" class="form-control"
                    onchange="showOtherField('brand', 'other_brand') ; updateModels()" required>
                    <option value="" selected>Choose a Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
                @error('brand_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="text" name="other_brand" id="other_brand" class="form-control mt-3" style="display:none;"
                    placeholder="Enter brand">
            </div>

            <div class="form-group">
                <label for="model">Model:</label>
                <select name="model_id" id="model" class="form-control"
                    onchange="showOtherField('model', 'other_model')">
                    <option value="" selected>Select a model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" brand_id = "{{ $model->brand_id }}">{{ $model->name }}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
                @error('model_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="text" name="other_model" id="other_model" class="form-control mt-3" style="display:none;"
                    placeholder="Enter model">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="year" class="form-control" min="1886"
                        max="{{ date('Y') }}" oninput="calculateCarAge()" placeholder="Enter year of manufacture" required>
                    @error('year')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <span id="year_error" class="text-danger"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="car_age">Car Age:</label>
                    <input type="text" id="car_age" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="used_or_new">Condition:</label>
                <select name="used_or_new_id" id="used_or_new" class="form-control" required>
                    <option value="" selected>Select Condition</option>
                    @foreach ($usedOrNews as $usedOrNew)
                        <option value="{{ $usedOrNew->id }}">{{ $usedOrNew->name }}</option>
                    @endforeach
                </select>
                @error('used_or_new_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="state">State:</label>
                <select name="state_id" id="state" class="form-control"
                    onchange="showOtherField('state', 'other_state')">
                    <option value="" selected>Select State</option>
                    @foreach ($state as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
                @error('state_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="text" name="other_state" id="other_state" class="form-control mt-3" style="display:none;"
                    placeholder="Enter state">
            </div>


            <div class="form-group">
                <label for="transmission">Transmission:</label>
                <select name="transmission_id" id="transmission" class="form-control">
                    <option value="" selected>Select transmission type</option>
                    @foreach ($transmissions as $transmission)
                        <option value="{{ $transmission->id }}">{{ $transmission->name }}</option>
                    @endforeach
                </select>
                @error('transmission_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="drivetype">Drive Type:</label>
                <select name="drivetype_id" id="drivetype" class="form-control">
                    <option value="">Choose drive type</option>
                    @foreach ($driveTypes as $driveType)
                        <option value="{{ $driveType->id }}">{{ $driveType->name }}</option>
                    @endforeach
                </select>
                @error('drivetype_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fueltype">Fuel Type:</label>
                <select name="fueltype_id" id="fueltype" class="form-control">
                    <option value="">Choose fuel type</option>
                    @foreach ($fuelTypes as $fuelType)
                        <option value="{{ $fuelType->id }}">{{ $fuelType->name }}</option>
                    @endforeach
                </select>
                @error('fueltype_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bodytype">Body Type:</label>
                <select name="bodytype_id" id="bodytype" class="form-control">
                    <option value="">Choose body type</option>
                    @foreach ($bodyTypes as $bodyType)
                        <option value="{{ $bodyType->id }}">{{ $bodyType->name }}</option>
                    @endforeach
                </select>
                @error('bodytype_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="doors">Number of Doors:</label>
                    <input type="number" name="doors" id="doors" class="form-control" min="1"
                        max="5" oninput="validateDoorsAndSeats()" placeholder="Enter number of doors (1 to 5)">
                    @error('doors')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <span id="doors_error" class="text-danger"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="seats">Number of Seats:</label>
                    <input type="number" name="seats" id="seats" class="form-control" min="1"
                        max="22" oninput="validateDoorsAndSeats()"  placeholder="Enter number of seats (1 to 22)">
                    @error('seats')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <span id="seats_error" class="text-danger"></span>
                </div>

            </div>

            <div class="form-group">
                <label for="cylinders">Cylinders:</label>
                <input type="number" name="cylinders" id="cylinders" class="form-control"
                    min="1" max="12" oninput="validateCylinders()" placeholder="Enter number of cylinders (between 1 and 12)">
                @error('cylinders')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="cylinders_error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="engine_l">Engine Liter:</label>
                <input type="number" step="0.1" name="engine_l" id="engine_l" class="form-control"
                    min="0.6" max="8.0" oninput="validateEngineFuelKm()" placeholder="Enter engine size in liters (between 0.6 and 8.0)">
                @error('engine_l')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="engine_l_error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="fuelconsumption">Fuel Consumption (L/100km):</label>
                <input type="number" step="0.1" name="fuelconsumption" id="fuelconsumption" class="form-control"
                    min="3" max="30" oninput="validateEngineFuelKm()" placeholder="Enter fuel consumption (between 3 and 30)">
                @error('fuelconsumption')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="fuelconsumption_error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="kilometers">Kilometers:</label>
                <input type="number" name="kilometers" id="kilometers" class="form-control" min="0"
                    oninput="validateEngineFuelKm()" placeholder="Enter number of kilometers driven" required>
                @error('kilometers')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="kilometers_error" class="text-danger"></span>
            </div>

            <button type="submit" class="sellCarBtn">Submit</button>
        </form>

        <script src="{{ asset('js/sell-car.js') }}"></script>

    </div>
@endsection
