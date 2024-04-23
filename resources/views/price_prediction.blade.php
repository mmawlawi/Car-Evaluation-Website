@extends('layout')

@section('title', 'Car Price Prediction')
<link rel="stylesheet" href="{{ asset('css/price-prediction.css') }}">
@section('content')
    <div class="price-prediction-container" id="carPredictionContainer">
        <h1 class="price-prediction-title">Car Price Prediction</h1>
        <p class="price-prediction-info"><strong>Predicted Price:</strong> {{ number_format($prediction ?? 0, 2) }}</p>
        @if (!empty($confidenceInterval))
            <p class="price-prediction-info"><strong>How acurate are the Results:</strong>
                {{ number_format($confidenceInterval * 100 ?? 0, 2) }}%
            </p>
        @endif
        @if (!empty($missing_fields))
            <p class="price-prediction-info"><strong>Missing Fields:</strong> {{ implode(', ', $missing_fields) }}</p>
        @endif

        {{-- Displaying Car Details --}}
        <div class="price-prediction-details">
            <h2>Car Details Confirmation</h2>
            @if (!empty($DisplayData))
                <ul>
                    @foreach ($DisplayData as $key => $value)
                        <li>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</li>
                    @endforeach
                </ul>
            @else
                <p>No car details found.</p>
            @endif
        </div>

        <form id="priceForm" class="price-prediction-form" action="{{ route('submit-price') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="userPrice">Enter Your Price ($):</label>
                <input type="numeric" class="form-control" id="userPrice" name="userPrice"
                    value="{{ number_format($prediction ?? 0, 2, '.', '') }}" required step="0.01">
                <small id="priceHelp" class="form-text text-muted"></small>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="price-prediction-container" id="carPredictionContainer2">
        <h1 class="price-prediction-title">How Features Influence Prediction</h1>
        <p class="price-prediction-info">This graph displays the relative importance of each feature used in predicting car
            prices. Features with higher values have a greater impact on the prediction outcome, highlighting the factors
            that significantly affect car valuations.</p>
        <div id="featureGraphContainer">
            <img id="featureImportanceGraph" style="width: 100%" src="{{ asset('images/feature-importance.jpg') }}"
                alt="Feature Importance Graph" onerror="fetchFeatureImportanceGraph()">
        </div>
    </div>

    <script>
        function fetchFeatureImportanceGraph() {
            const graphElement = document.getElementById('featureImportanceGraph');
            if (!graphElement.complete || graphElement.naturalWidth === 0) {
                fetch('/predict/feature-importance-graph')
                    .then(response => response.blob())
                    .then(imageBlob => {
                        const imageUrl = URL.createObjectURL(imageBlob);
                        graphElement.src = imageUrl;
                        graphElement.alt = "Feature Importance Graph";
                    }).catch(error => {
                        console.error('Error fetching feature graph:', error);
                        document.getElementById('featureGraphContainer').innerText =
                            'Failed to load feature importance graph.';
                    });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Price validation
            const userPriceInput = document.getElementById('userPrice');
            const priceHelp = document.getElementById('priceHelp');
            const predictedPrice = parseFloat(userPriceInput.value.replace(/,/g, '')); // remove commas for parsing
            const confidenceScale = {{ $confidenceInterval ?? 0.85 }}
            const priceRangeFactor = 1 - confidenceScale; // Smaller range when confidence is high

            const lowerPriceRange = predictedPrice - (predictedPrice * priceRangeFactor);
            const upperPriceRange = predictedPrice + (predictedPrice * priceRangeFactor);

            userPriceInput.addEventListener('input', function() {
                const userPrice = parseFloat(userPriceInput.value);
                if (userPrice < lowerPriceRange) {
                    priceHelp.textContent = 'Price too low. Expected range: $' + lowerPriceRange.toFixed(
                        2) + ' - $' + upperPriceRange.toFixed(2);
                    priceHelp.className = 'form-text text-warning';
                } else if (userPrice > upperPriceRange) {
                    priceHelp.textContent = 'Price too high. Expected range: $' + lowerPriceRange.toFixed(
                        2) + ' - $' + upperPriceRange.toFixed(2);
                    priceHelp.className = 'form-text text-warning';
                } else {
                    priceHelp.textContent = 'Price within expected range: $' + lowerPriceRange.toFixed(2) +
                        ' - $' + upperPriceRange.toFixed(2);
                    priceHelp.className = 'form-text text-success';
                }
            });
        });

        document.getElementById('priceForm').addEventListener('submit', function() {
            var userPriceInput = document.getElementById('userPrice');
            userPriceInput.value = userPriceInput.value.replace(/,/g, ''); // Remove commas
        });
    </script>
@endsection
