{{-- resources/views/price_prediction.blade.php --}}
@extends('layout')

@section('title', 'Car Price Prediction')

@section('content')
    <div class="container mt-5">
        <h1>Car Price Prediction</h1>
        <p><strong>Predicted Price:</strong> {{ number_format($prediction ?? 0, 2) }}</p>
        @if (!empty($confidenceInterval))
            <p><strong>Confidence Interval:</strong>
                {{ ((number_format($confidenceInterval['lower'] + number_format($confidenceInterval['upper']))) / 2) * 100 }}%
            </p>
        @endif
        @if (!empty($missing_fields))
            <p><strong>Missing Fields:</strong> {{ implode(', ', $missing_fields) }}</p>
        @endif

        {{-- Displaying Car Details --}}
        <div class="mt-4 mb-4">
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
        
        <form id="priceForm" action="{{ route('submit-price') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="userPrice">Enter Your Price ($):</label>
                <input type="numeric" class="form-control" id="userPrice" name="userPrice"
                    value="{{ number_format($prediction ?? 0, 2) }}" required step="0.01">
                <small id="priceHelp" class="form-text text-muted"></small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container mt-5">
        <h1>How Features Influence Prediction</h1>
        <p>This graph displays the relative importance of each feature used in predicting car prices. Features with higher
            values have a greater impact on the prediction outcome, highlighting the factors that significantly affect car
            valuations.</p>
        <div id="featureGraphContainer">
            <img id="featureImportanceGraph" src="{{ asset('storage/feature_importance_graph.png') }}"
                alt="Feature Importance Graph" onerror="fetchFeatureImportanceGraph()">
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // Price validation
            const userPriceInput = document.getElementById('userPrice');
            const priceHelp = document.getElementById('priceHelp');
            const predictedPrice = parseFloat(userPriceInput.value.replace(/,/g, '')); // remove commas for parsing
            const confidenceScale = ({{ $confidenceInterval['lower'] ?? 0.85 }} +
                    {{ $confidenceInterval['upper'] ?? 0.85 }}) /
                2; // Average of lower and upper confidence percentages
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
    </script>
@endsection
