@extends('layout')


@section('title', 'Sell Your Car')
@section('content')
    <div class="container">
        <h1>Sell Your Car</h1>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label for="make">Car Make:</label>
                <input type="text" class="form-control" id="make" name="make" required>
            </div>
            <div class="form-group">
                <label for="model">Car Model:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="year">Car Year:</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="form-group">
                <label for="price">Asking Price:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection