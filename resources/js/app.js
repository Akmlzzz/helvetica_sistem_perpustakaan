import "./bootstrap";

document.addEventListener("DOMContentLoaded", () => {
    // Select all eye icons
    const togglePasswordIcons = document.querySelectorAll(
        ".bi-eye-slash, .bi-eye",
    );

    togglePasswordIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
            // Find the input field related to this icon (previous sibling or by context)
            // Assuming icon is inside .form-group and input is its sibling
            const input = this.parentElement.querySelector("input");

            if (input && input.type === "password") {
                input.type = "text";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
                this.classList.add("active-icon"); // Add active class
            } else if (input) {
                input.type = "password";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
                this.classList.remove("active-icon"); // Remove active class
            }
        });
    });
});
