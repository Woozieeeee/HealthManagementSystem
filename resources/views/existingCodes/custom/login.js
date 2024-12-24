document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');

    // Toggle Password Visibility
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Simulate Modal Triggering After Submission
    const form = document.getElementById('login-form');
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent traditional form submission

        // Simulate a server response (for demonstration purposes)
        const isSuccess = Math.random() > 0.5; // Randomly decide success or failure

        if (isSuccess) {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        } else {
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    });
});