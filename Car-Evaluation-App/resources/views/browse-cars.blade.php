@extends('layout')

@section('title', 'Browse Cars')
@section('content')
    <div class="container">
        <h2>Search Results</h2>
        @if ($allCars->isEmpty())
            <p>No cars found matching your search criteria.</p>
        @else
            <div class="row">
                @foreach ($allCars as $car)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            {{-- Assuming you have a way to get the brand name and model name --}}
                            <div class="card-header">
                                {{ optional($car->model->brand)->name }} {{ optional($car->model)->name }}
                            </div>
                            <div class="card-body">
                                <p><strong>Year:</strong> {{ $car->year }}</p>
                                <p><strong>Price:</strong> ${{ number_format($car->price, 2) }}</p>
                                {{-- Add more car details here --}}
                                <a href="{{ url('cars/' . $car->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Pagination Links --}}
            {{-- If you have many cars and are using Laravel's pagination, uncomment below --}}
            {{-- {{ $allCars->links() }} --}}
        @endif
    </div>

@endsection
