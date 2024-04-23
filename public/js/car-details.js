document.addEventListener('DOMContentLoaded', (event) => {
    const contactButton = document.getElementById('contactSellerButton');
    const closeButton = document.getElementsByClassName('close-button')[0];
    const modal = document.getElementById('contactSellerModal');

    contactButton.onclick = function() {
        modal.style.display = "block";
    }

    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
