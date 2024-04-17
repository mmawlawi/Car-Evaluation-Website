@extends('layout')

@section('title', 'My Cars')
<link rel="stylesheet" href="{{ asset('css/my-cars.css') }}">
@section('content')
    <div class="container mt-5" id="myCarsContainer">
        <h1>My Cars</h1>
        @if ($cars->isEmpty())
            <p>You currently have no cars listed. <a href="{{ route('sell-your-car') }}">Sell your car?</a></p>
        @else
            <div class="list-group">
                @foreach ($cars as $car)
                <a class = "carbox" href = "{{route('cardetails' , $car) }}" >
                    <div onclick = "{{route('cardetails' , $car) }}" class="list-group-item">
                        <h5>{{ $car->brand->name ?? 'Brand Not Available' }} -
                            {{ $car->model->name ?? 'Model Not Available' }}</h5>
                        <p>Year: {{ $car->year }}</p>
                        <p>Kilometers: {{ number_format($car->kilometers) }}</p>
                        <p>Price: ${{ number_format($car->price, 2) }}</p>
                        <div>
                            {{-- <a href="{{ route('edit-car', $car->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('delete-car', $car->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a> --}}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
