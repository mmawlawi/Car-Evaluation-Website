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