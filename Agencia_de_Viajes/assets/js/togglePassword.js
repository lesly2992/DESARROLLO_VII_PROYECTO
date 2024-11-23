function togglePasswordVisibility() {
  const passwordInput = document.getElementById("password");
  const icon = document.querySelector(".toggle-password");

  const passwordInputRepet = document.getElementById("passwordConfirm");
  const iconRepet = document.querySelector(".toggle-passwordRegister");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.textContent = "🙈"; // Cambia el ícono cuando se muestra la contraseña
  } else {
    passwordInput.type = "password";
    icon.textContent = "👁️"; // Cambia el ícono cuando se oculta la contraseña
  }

  // if (passwordInputRepet.type === "passwordConfirm") {
  //   passwordInputRepet.type = "text";
  //   iconRepet.textContent = "🙈"; // Cambia el ícono cuando se muestra la contraseña
  // } else {
  //   passwordInputRepet.type = "passwordConfirm";
  //   iconRepet.textContent = "👁️"; // Cambia el ícono cuando se oculta la contraseña
  // }
}
