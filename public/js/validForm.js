var imageInput = document.getElementById("serie_image")
var error = document.getElementById("error")
var btnSave = document.getElementById("btnSave")
imageInput.addEventListener('input', callback2)

function callback() {
    error.innerHTML = ''
    if (imageInput.value.search(/..*\.png$/) != -1) {
        btnSave.disabled = false
    } else if (imageInput.value.search(/..*\.jpg$/) != -1) {
        btnSave.disabled = false
    } else {
        error.innerHTML = 'La saisie n\'est pas valide'
        btnSave.disabled = true
    }
}

function callback2() {
    error.innerHTML = '';
    const fileRegex = /..*\.(png|jpg)$/i; // Utilisation d'une expression régulière unique pour les fichiers PNG et JPG
    const isValid = fileRegex.test(imageInput.value);
    btnSave.disabled = !isValid;
    if (!isValid) {
      error.innerHTML = 'La saisie n\'est pas valide';
    }
}