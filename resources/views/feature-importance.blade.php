{{-- Check if the imagePath variable exists and is not empty --}}
@if(!empty($imagePath))
    <div>
        <img src="{{ asset($imagePath) }}" alt="Feature Importance Graph">
    </div>
@else
    <p>Graph not available.</p>
@endif
