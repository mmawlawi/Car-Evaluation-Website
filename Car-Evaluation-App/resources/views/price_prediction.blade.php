{{-- resources/views/price_prediction.blade.php --}}
@extends('layout')

@section('title', 'Car Price Prediction')

@section('content')
    <div class="container mt-5">
        <h1>Car Price Prediction</h1>
        <p><strong>Predicted Price: </strong>{{ number_format($prediction ?? 0, 2) }}</p>
        @if (!empty($missing_fields))
            <p><strong>Missing Fields:</strong> {{ implode(', ', $missing_fields) }}</p>
        @endif
    </div>

    <div class="container mt-5">
        <h1>How Features Influence Prediction</h1>
        <div>
            <img src="{{ asset('storage/feature_importance_graph.png') }}" alt="Feature Importance Graph">
        </div>
    </div>

@endsection
