import 'bootstrap';
import ApexCharts from 'apexcharts';
import Alpine from 'alpinejs';
import 'datatables.net-bs5';
import $ from 'jquery';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';
import './custom/navbar.js';
import './custom/login.js';
import '@popperjs/core';


window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 1000,
        once: true,
    });

    const navbar = document.querySelector('.blurry-navbar');
    if (navbar) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password-confirm');
    const passwordMatchMessage = document.getElementById('password-match-message');
    const registerButton = document.getElementById('register-button');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const togglePasswordConfirmBtn = document.getElementById('toggle-password-confirm');

    if (passwordInput && passwordConfirmInput && togglePasswordBtn && togglePasswordConfirmBtn) {
        togglePasswordBtn.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePasswordBtn.textContent = type === 'password' ? 'Show' : 'Hide';
        });

        togglePasswordConfirmBtn.addEventListener('click', () => {
            const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
            passwordConfirmInput.type = type;
            togglePasswordConfirmBtn.textContent = type === 'password' ? 'Show' : 'Hide';
        });

        function checkPasswords() {
            const pwd = passwordInput.value;
            const pwdConfirm = passwordConfirmInput.value;

            if (!pwd || !pwdConfirm) {
                passwordMatchMessage.textContent = '';
                return;
            }

            if (pwd === pwdConfirm) {
                passwordMatchMessage.textContent = 'Passwords Match';
                passwordMatchMessage.classList.remove('text-danger');
                passwordMatchMessage.classList.add('text-success');
                registerButton.disabled = false;
            } else {
                passwordMatchMessage.textContent = 'Passwords do not match';
                passwordMatchMessage.classList.remove('text-success');
                passwordMatchMessage.classList.add('text-danger');
                registerButton.disabled = true;
            }
        }

        passwordInput.addEventListener('input', checkPasswords);
        passwordConfirmInput.addEventListener('input', checkPasswords);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contact-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting traditionally

        console.log('Form submitted');

        const formData = new FormData(form);

        // Ensure form.action is defined
        if (!form.action) {
            console.error('Form action URL is not defined.');
            alert('Unable to submit the form. Please contact support.');
            return;
        }

        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // Include CSRF token
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not OK (status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show a success message
                    alert(data.success);

                    // Optionally reset the form
                    form.reset();
                } else {
                    alert('Submission failed. Please check your input and try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error.message || error);
                alert('Something went wrong. Please try again later.');
            });
    });
});
