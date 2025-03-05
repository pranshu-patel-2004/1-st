document.addEventListener("DOMContentLoaded", function() {
    // Ensure the popup is hidden when the page loads
    document.getElementById('customerPopup').style.display = 'none';
});

// Function to show the popup only when the button is clicked
function showPopup() {
    document.getElementById('customerPopup').style.display = 'flex';
}

// Function to hide the popup
function closePopup() {
    document.getElementById('customerPopup').style.display = 'none';
}

// Function to fetch states based on selected country
function loadStates(countryId) {
    if (countryId) {
        fetch('/states/' + countryId)
            .then(response => response.json())
            .then(data => {
                const stateSelect = document.getElementById('state');
                stateSelect.innerHTML = '<option value="">Select State</option>';  

                data.forEach(function(state) {
                    const option = document.createElement('option');
                    option.value = state.id;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });
            });
    }
}

// Function to fetch cities based on selected state
function loadCities(stateId) {
    if (stateId) {
        fetch('/cities/' + stateId)
            .then(response => response.json())
            .then(data => {
                const citySelect = document.getElementById('city');
                citySelect.innerHTML = '<option value="">Select City</option>';  

                data.forEach(function(city) {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            });
    }
}

// --------------------------------------------------------------------------------------
// this is for add product (multiple time)



$(document).ready(function(){
    $('#tags').tagsinput();

    document.getElementById('addMore').addEventListener('click', function() {
        let newRow = document.querySelector('.variantRow').cloneNode(true);
        newRow.querySelectorAll("input").forEach(input => input.value = "");
        document.getElementById('variantContainer').appendChild(newRow);
    });

    document.getElementById('variantContainer').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            if (document.querySelectorAll('.variantRow').length > 1) {
                e.target.closest('.variantRow').remove();
            }
        }
    });
})