
//doing password visibility logic.
document.addEventListener("DOMContentLoaded", function(){
    function togglePassword(inputID, toggledID){
        const passwordField = document.getElementById(inputID);
        const toggleButton = document.getElementById(toggledID);

        if (passwordField && toggleButton){
            toggleButton.addEventListener('click', function(){
                passwordField.type = passwordField.type === "password" ? "text" : "password";
                toggleButton.classList.toggle("fa-eye");
                toggleButton.classList.toggle("fa-eye-slash");
            });
        }
    }
    togglePassword("password", "togglePassword");
    togglePassword("confirmPassword", "toggleConfirmPassword");
});

