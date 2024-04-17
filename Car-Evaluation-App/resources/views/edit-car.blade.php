@extends('layout')

@section('title', 'Edit Your Car')
<link rel="stylesheet" href="{{ asset('css/sell-car.css') }}">

@section('content')
    <div class="container mt-5">
        <h1>Edit Your Car</h1>
        <form action="{{ route('update-car', $car['id']) }}" method="POST" class="needs-validation">
            @csrf
            @method('PUT')

            <!-- Brand Selection -->
            <div class="form-group">
                <label for="brand">Brand:</label>
                <select name="brand_id" id="brand" class="form-control" onchange="updateModels()" required>
                    <option value="">Choose a Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $car['brand_id'] == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}</option>
                    @endforeach
                    <option value="other" {{ $car['brand_id'] == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('brand_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Model Selection -->
            <div class="form-group">
                <label for="model">Model:</label>
                <select name="model_id" id="model" class="form-control">
                    <option value="">Select a Model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" {{ $car['model_id'] == $model->id ? 'selected' : '' }}
                            brand_id="{{ $model->brand_id }}">
                            {{ $model->name }}</option>
                    @endforeach
                    <option value="other" {{ $car['model_id'] == 'other' ? 'selected' : '' }} brand_id="Other">Other
                    </option>
                </select>
                @error('model_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <!-- Year Input -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="year" class="form-control" min="1886"
                        max="{{ date('Y') }}" value="{{ $car['year'] }}" required>
                    @error('year')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Display Calculated Car Age -->
                <div class="form-group col-md-6">
                    <label for="car_age">Car Age:</label>
                    <input type="text" id="car_age" class="form-control" value="{{ date('Y') - $car['year'] }}"
                        readonly>
                </div>
            </div>

            <!-- Condition Selection -->
            <div class="form-group">
                <label for="used_or_new">Condition:</label>
                <select name="used_or_new_id" id="used_or_new" class="form-control" required>
                    <option value="">Select Condition</option>
                    @foreach ($usedOrNews as $usedOrNew)
                        <option value="{{ $usedOrNew->id }}"
                            {{ $car['used_or_new_id'] == $usedOrNew->id ? 'selected' : '' }}>
                            {{ $usedOrNew->name }}</option>
                    @endforeach
                </select>
                @error('used_or_new_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- State Selection -->
            <div class="form-group">
                <label for="state">State:</label>
                <select name="state_id" id="state" class="form-control">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ $car['state_id'] == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}</option>
                    @endforeach
                    <option value="other" {{ $car['state_id'] == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('state_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Transmission Selection -->
            <div class="form-group">
                <label for="transmission">Transmission:</label>
                <select name="transmission_id" id="transmission" class="form-control">
                    <option value="">Select Transmission Type</option>
                    @foreach ($transmissions as $transmission)
                        <option value="{{ $transmission->id }}"
                            {{ $car['transmission_id'] == $transmission->id ? 'selected' : '' }}>
                            {{ $transmission->name }}</option>
                    @endforeach
                </select>
                @error('transmission_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Drive Type Selection -->
            <div class="form-group">
                <label for="drivetype">Drive Type:</label>
                <select name="drivetype_id" id="drivetype" class="form-control">
                    <option value="">Choose Drive Type</option>
                    @foreach ($driveTypes as $driveType)
                        <option value="{{ $driveType->id }}"
                            {{ $car['drivetype_id'] == $driveType->id ? 'selected' : '' }}>
                            {{ $driveType->name }}</option>
                    @endforeach
                </select>
                @error('drivetype_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Fuel Type Selection -->
            <div class="form-group">
                <label for="fueltype">Fuel Type:</label>
                <select name="fueltype_id" id="fueltype" class="form-control">
                    <option value="">Choose Fuel Type</option>
                    @foreach ($fuelTypes as $fuelType)
                        <option value="{{ $fuelType->id }}" {{ $car['fueltype_id'] == $fuelType->id ? 'selected' : '' }}>
                            {{ $fuelType->name }}</option>
                    @endforeach
                </select>
                @error('fueltype_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Body Type Selection -->
            <div class="form-group">
                <label for="bodytype">Body Type:</label>
                <select name="bodytype_id" id="bodytype" class="form-control">
                    <option value="">Choose Body Type</option>
                    @foreach ($bodyTypes as $bodyType)
                        <option value="{{ $bodyType->id }}" {{ $car['bodytype_id'] == $bodyType->id ? 'selected' : '' }}>
                            {{ $bodyType->name }}</option>
                    @endforeach
                </select>
                @error('bodytype_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Doors Input -->
            <div class="form-group">
                <label for="doors">Number of Doors:</label>
                <input type="number" name="doors" id="doors" class="form-control" value="{{ $car['doors'] ?? '' }}"
                    min="1" max="5" oninput="validateDoorsAndSeats()"
                    placeholder="Enter number of doors (1 to 5)">
                @error('doors')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="doors_error" class="text-danger"></span>
            </div>

            <!-- Seats Input -->
            <div class="form-group">
                <label for="seats">Number of Seats:</label>
                <input type="number" name="seats" id="seats" class="form-control"
                    value="{{ $car['seats'] ?? '' }}" min="1" max="22" oninput="validateDoorsAndSeats()"
                    placeholder="Enter number of seats (1 to 22)">
                @error('seats')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="seats_error" class="text-danger"></span>
            </div>

            <!-- Cylinders Input -->
            <div class="form-group">
                <label for="cylinders">Cylinders:</label>
                <input type="number" name="cylinders" id="cylinders" class="form-control"
                    value="{{ $car['cylinders'] ?? '' }}" min="1" max="12" oninput="validateCylinders()"
                    placeholder="Enter number of cylinders (between 1 and 12)">
                @error('cylinders')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="cylinders_error" class="text-danger"></span>
            </div>

            <!-- Engine Liter Input -->
            <div class="form-group">
                <label for="engine_l">Engine Liter:</label>
                <input type="number" step="0.1" name="engine_l" id="engine_l" class="form-control"
                    value="{{ $car['engine_l'] ?? '' }}" min="0.6" max="8.0" oninput="validateEngineFuelKm()"
                    placeholder="Enter engine size in liters (between 0.6 and 8.0)">
                @error('engine_l')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="engine_l_error" class="text-danger"></span>
            </div>

            <!-- Fuel Consumption Input -->
            <div class="form-group">
                <label for="fuelconsumption">Fuel Consumption (L/100km):</label>
                <input type="number" step="0.1" name="fuelconsumption" id="fuelconsumption" class="form-control"
                    value="{{ $car['fuelconsumption'] ?? '' }}" min="3" max="30"
                    oninput="validateEngineFuelKm()" placeholder="Enter fuel consumption (between 3 and 30)">
                @error('fuelconsumption')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="fuelconsumption_error" class="text-danger"></span>
            </div>

            <!-- Kilometers Input -->
            <div class="form-group">
                <label for="kilometers">Kilometers:</label>
                <input type="number" name="kilometers" id="kilometers" class="form-control"
                    value="{{ $car['kilometers'] ?? '' }}" min="0" oninput="validateEngineFuelKm()"
                    placeholder="Enter number of kilometers driven" required>
                @error('kilometers')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span id="kilometers_error" class="text-danger"></span>
            </div>

            <button type="submit" class="sellCarBtn">Update Car</button>
        </form>
    </div>
    <script src="{{ asset('js/sell-car.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateModels();
        });
    </script>
@endsection
