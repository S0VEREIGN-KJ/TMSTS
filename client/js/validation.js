document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#Sign_up");

    // Password visibility toggle
    function seePass() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    }

    function seeConfirmPass() {
        const confirmPasswordInput = document.getElementById("password_confirmation");
        confirmPasswordInput.type = confirmPasswordInput.type === "password" ? "text" : "password";
    }

    // Password match validation
    function checkPasswordsMatch() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("password_confirmation").value;
        const errorMessage = document.getElementById("password-error");

        if (password !== confirmPassword) {
            errorMessage.textContent = "Passwords do not match!";
            errorMessage.style.color = "red";
        } else {
            errorMessage.textContent = "";
        }
    }

    // Email availability check
    function validateEmailAvailability(email) {
        return fetch(`validate-email.php?email=${encodeURIComponent(email)}`)
            .then((response) => response.json())
            .then((data) => {
                const emailInput = document.getElementById("email");
                const errorMessage = document.createElement("div");
                errorMessage.id = "email-error";
                if (!data.available) {
                    errorMessage.textContent = "Email is already taken.";
                    errorMessage.style.color = "red";
                    emailInput.insertAdjacentElement("afterend", errorMessage);
                } else {
                    const existingError = document.getElementById("email-error");
                    if (existingError) {
                        existingError.remove();
                    }
                }
                return data.available;
            });
    }

    // Form submission
    form.addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent default form submission

        const email = document.getElementById("email").value;

        // Check email availability
        const isEmailAvailable = await validateEmailAvailability(email);
        if (!isEmailAvailable) {
            return; // Prevent submission if email is not available
        }

        // Final validation for passwords
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("password_confirmation").value;
        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        // If all validations pass, submit the form
        form.submit();
    });

    // Attach event listeners
    document.getElementById("password").addEventListener("input", checkPasswordsMatch);
    document.getElementById("password_confirmation").addEventListener("input", checkPasswordsMatch);
    document.querySelector("input[onclick='seePass()']").addEventListener("click", seePass);
    document.querySelector("input[onclick='seeConfirmPass()']").addEventListener("click", seeConfirmPass);
});
