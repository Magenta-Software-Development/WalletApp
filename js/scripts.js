const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link a");
signupBtn.onclick = (() => {
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
});
loginBtn.onclick = (() => {
    loginForm.style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
});
signupLink.onclick = (() => {
    signupBtn.click();
    return false;
});

function checkPassword(pass) { //Funcion validar contraseña

    var password = document.getElementById("pass2").value; //Obtener valor de contraseña

    if (password.length < "8") { //Validar contraseña

        document.getElementById("pass2").style.border = "1px solid red"; //Cambiar color de contraseña
        alert("La contraseña debe ser de al menos 8 caracteres como minimo"); //Mostrar mensaje de error
        document.getElementById("pass2").value = ""; //Limpiar contraseña
        return false
    } else if (password.indexOf(" ") > -1) { //Validar contraseña
        alert("La contraseña no puede contener espacios"); //Mostrar mensaje de error
        document.getElementById("pass2").value = ""; //Limpiar contraseña
        return false;
    } else if (!password.includes("+") && !password.includes("*") && !password.includes(".")) { //Validar contraseña
        alert("La contraseña debe incluir +,* o .")
        return false
    }
}