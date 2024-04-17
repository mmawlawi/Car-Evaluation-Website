@extends('layout')

@section('title', 'My Cars')
<link rel="stylesheet" href="{{ asset('css/my-cars.css') }}">
@section('content')
    <div class="container mt-5" id="myCarsContainer">
        <h1>My Cars</h1>
        <!-- Display status messages -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if ($cars->isEmpty())
            <p>You currently have no cars listed. <a href="{{ route('sell-your-car') }}">Sell your car?</a></p>
        @else
            <div class="list-group">
                @foreach ($cars as $car)
                    <div class="list-group-item">
                        <h5>{{ $car->brand->name ?? 'Brand Not Available' }} -
                            {{ $car->model->name ?? 'Model Not Available' }}</h5>
                        <p>Year: {{ $car->year }}</p>
                        <p>Kilometers: {{ number_format($car->kilometers) }}</p>
                        <p>Price: ${{ number_format($car->price, 2) }}</p>
                        <div class="list-group-btns">
                            <a href="{{ route('edit-car', $car->id) }}" class="btn" id="edit-btn">Edit</a>
                            <form action="{{ route('delete-car', $car->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
