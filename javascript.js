function showAlert(background, font, text) {
    let alertBox = document.getElementsByClassName('alert-box')[0];
    let message = document.getElementsByClassName('message')[0];
    alertBox.style.display = 'block';
    message.innerHTML = text;
    alertBox.style.backgroundColor = background;
    alertBox.style.color = font;
    setTimeout(() => {
        alertBox.style.display = 'none';
    }, 5000)
    return 'true';
}

function closeAlert() {
    let alertBox = document.getElementsByClassName('alert-box')[0];
    alertBox.style.display = 'none';
}

function checkPassword(id) {
    let password = document.getElementById(id).value;
    let error = document.getElementsByClassName('password-error')[0];
    if (password.length < 8) {
        error.style.display = 'block';
        error.innerHTML = "Password must contain more than 8 characters.";
        return false;
    } else if (password.length > 16) {
        error.style.display = 'block';
        error.innerHTML = "Password length must not exceed 16 characters.";
        return false;
    }
    if (!/[A-Z]/.test(password)) {
        error.style.display = 'block';
        error.innerHTML = "Password must contain capital letters.";
        return false;
    }
    if (!/[a-z]/.test(password)) {
        error.style.display = 'block';
        error.innerHTML = "Password must contain small letters.";
        return false;
    }
    if (!/[0-9]/.test(password)) {
        error.style.display = 'block';
        error.innerHTML = "Password must contain numbers.";
        return false;
    }
}