/**
 * Show/hide toggle for password fields: <button data-password-toggle aria-controls="input-id">.
 */
document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const isHidden = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';
        button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        button.querySelector('i').className = isHidden ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
    });
});
