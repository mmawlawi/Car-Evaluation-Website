{{-- resources/views/price_prediction.blade.php --}}
@extends('layout')

@section('title', 'Car Price Prediction')

@section('content')
<div class="container mt-5">
    <h1>Car Price Prediction</h1>
    <p><strong>Predicted Price:</strong> {{ $prediction ?? 'Not available' }}</p>
    @if(!empty($missing_fields))
    <p><strong>Missing Fields:</strong> {{ implode(', ', $missing_fields) }}</p>
    @endif
</div>
@endsection
