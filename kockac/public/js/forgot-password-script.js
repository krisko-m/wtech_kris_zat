
function submitForgotPassword() {
    const email = document.getElementById('forgot-email').value;
    const error = document.getElementById('forgot-error');
    const emailForm = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailForm.test(email)) {
        error.style.display = 'block';
        return;
    }

    error.style.display = 'none';
    document.getElementById('forgot-form').style.display = 'none';
    document.getElementById('forgot-success').style.display = 'block';
}
