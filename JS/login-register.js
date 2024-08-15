const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");
const loginBtn = document.getElementById("login-btn");
const registerBtn = document.getElementById("register-btn");

loginBtn.addEventListener("click", () => {
    loginForm.classList.add("active-form");
    registerForm.classList.remove("active-form");
    loginBtn.classList.add("active");
    registerBtn.classList.remove("active");
});

registerBtn.addEventListener("click", () => {
loginForm.classList.remove("active-form");
registerForm.classList.add("active-form");
loginBtn.classList.remove("active");
registerBtn.classList.add("active"); 
});


