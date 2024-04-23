function updateModels() {
    const brandId = document.getElementById('make-filter').value;
    const modelDropdown = document.getElementById('model-filter');

    if (brandId) {
        fetch(`/models/${brandId}`)
            .then(response => response.json())
            .then(data => {
                modelDropdown.disabled = false;
                modelDropdown.innerHTML = '<option value="">Select Model</option>';
                data.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.name;
                    modelDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    } else {
        modelDropdown.disabled = true;
        modelDropdown.innerHTML = '<option value="">Select Model</option>';
    }
}


function updateYearValue() {
    const minYear = document.getElementById('year-min').value;
    const maxYear = document.getElementById('year-max').value;
    document.getElementById('year-range-value').textContent = `${minYear} - ${maxYear}`;
}

function updatePriceValue() {
    const minPrice = document.getElementById('price-min').value;
    const maxPrice = document.getElementById('price-max').value;
    document.getElementById('price-range-value').textContent = `$${minPrice} - $${maxPrice}`;
}

