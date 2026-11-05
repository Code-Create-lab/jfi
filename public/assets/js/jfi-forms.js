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

/**
 * Busy state for forms: <button type="submit" data-busy-label="Searching...">.
 * Stops double submits and tells the visitor the request is on its way.
 */
document.querySelectorAll('form').forEach((form) => {
    const button = form.querySelector('[type="submit"][data-busy-label]');

    if (!button) {
        return;
    }

    const label = button.innerHTML;

    form.addEventListener('submit', () => {
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.textContent = button.dataset.busyLabel;
    });

    // Pages restored with the Back button keep their old state; reset it.
    window.addEventListener('pageshow', () => {
        button.disabled = false;
        button.removeAttribute('aria-busy');
        button.innerHTML = label;
    });
});
