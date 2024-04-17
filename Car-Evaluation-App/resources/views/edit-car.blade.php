@extends('layout')

@section('title', 'Edit Your Car')
<link rel="stylesheet" href="{{ asset('css/sell-car.css') }}">

@section('content')
    <div class="container mt-5">
        <h1>Edit Your Car</h1>
        <form action="{{ route('update-car', $car['id']) }}" method="POST" class="needs-validation">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="brand">Brand:</label>
                <select name="brand_id" id="brand" class="form-control"
                    onchange="updateModels(); showOtherField('brand', 'other_brand')" required>
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
                <input type="text" name="other_brand" id="other_brand" class="form-control mt-3" style="display: none;"
                    value="{{ old('other_brand', $car['other_brand']) }}" placeholder="Enter brand">
                @error('other_brand')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="model">Model:</label>
                <select name="model_id" id="model" class="form-control"
                    onchange="showOtherField('model', 'other_model')">
                    <option value="">Select a model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" {{ $car['model_id'] == $model->id ? 'selected' : '' }}>
                            {{ $model->name }}</option>
                    @endforeach
                    <option value="other" {{ $car['model_id'] == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('model_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                {{-- <input type="text" name="other_model" id="other_model" class="form-control mt-3" style="display: none;"
                    value="{{ old('other_model', $car['other_model']) }}" placeholder="Enter model">
                @error('other_model')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror --}}
            </div>

            <!-- Additional fields similar to the create form, but with pre-filled data -->
            <!-- Use $car->attribute to pre-fill each input -->

            <button type="submit" class="btn btn-primary">Update Car</button>
        </form>

    </div>
    <script src="{{ asset('js/sell-car.js') }}"></script>
@endsection
