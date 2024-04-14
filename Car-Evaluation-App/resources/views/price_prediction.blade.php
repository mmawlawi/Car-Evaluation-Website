{{-- resources/views/price_prediction.blade.php --}}
@extends('layout')

@section('title', 'Car Price Prediction')

@section('content')
    <div class="container mt-5">
        <h1>Car Price Prediction</h1>
        <p><strong>Predicted Price:</strong> {{ number_format($prediction ?? 0, 2) }}</p>
        @if (!empty($missing_fields))
            <p><strong>Missing Fields:</strong> {{ implode(', ', $missing_fields) }}</p>
        @endif
        @if (!empty($confidenceInterval))
            <p><strong>Confidence Interval:</strong> {{ number_format($confidenceInterval['lower'] * 100, 2) }}% -
                {{ number_format($confidenceInterval['upper'] * 100, 2) }}%</p>
        @endif
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
                        .then(response => {
                            if (response.ok) return response.blob();
                            throw new Error('Failed to load graph image');
                        })
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
        });
    </script>

@endsection
