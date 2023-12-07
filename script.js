// Wait for the DOM to fully load before attaching JavaScript behaviors.
document.addEventListener('DOMContentLoaded', function() {

    // Function to display a modal instead of using alert.
    function displayModal(message) {
        // Create a new div element for the modal.
        var modal = document.createElement('div');
        modal.classList.add('modal');
        
        // Create the inner content of the modal.
        var modalContent = document.createElement('div');
        modalContent.classList.add('modal-content');
        modalContent.textContent = message;

        // Append the modal content to the modal.
        modal.appendChild(modalContent);

        // When the user clicks anywhere outside of the modal, close it
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
        
        document.body.appendChild(modal);
        modal.style.display = 'block';
    }

    function validateRegistrationForm() {
        var username = document.getElementById('newUsername').value;
        var email = document.getElementById('newEmail').value;
        var password = document.getElementById('newPassword').value;
        var valid = true;

        // Check for a valid username.
        if (username === '') {
            displayModal('Please enter a username.');
            valid = false;
        }

        // Check for a valid email.
        if (email === '' || !email.includes('@')) {
            displayModal('Please enter a valid email address.');
            valid = false;
        }

        // Check for a password of sufficient length.
        if (password.length < 6) {
            displayModal('Password must be at least 6 characters long.');
            valid = false;
        }
        return valid;
    }

    // Get the registration form and attach the validation function to the submit event.
    var registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            // Prevent the form from submitting.
            event.preventDefault();

            // Validate the form and if valid, submit the form.
            if (validateRegistrationForm()) {
                registrationForm.submit();
            }
        });
    }
});
