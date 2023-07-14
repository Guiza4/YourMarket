$(document).ready(function () {
    // Get the range input and selected value element
    var rangeInput = $('.form-range');
    var selectedValue = $('.selected-value');

    // Update the selected value when the range input value changes
    rangeInput.on('input', function () {
        selectedValue.text(rangeInput.val());
    });

    // Update the range input value when the selected value is manually changed
    selectedValue.on('input', function () {
        rangeInput.val(selectedValue.text());
    });
});
