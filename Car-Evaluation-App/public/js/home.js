<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
$(document).ready(function () {
    $('#make-filter').on('change', function () {
        var selectedMake = $(this).val();

        $('.car-item').each(function () {
            var carMake = $(this).data('make');

            if (selectedMake === 'all' || selectedMake === carMake) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
