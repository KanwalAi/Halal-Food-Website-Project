// Check Login Status on every page
window.onload = function() {
    const user = localStorage.getItem("loggedInUser");
    const userSpan = document.getElementById("username");
    if (userSpan && user) userSpan.innerText = user;
};

function signupUser() {
    const name = document.getElementById("signupName").value;
    localStorage.setItem("userName", name);
    localStorage.setItem("loggedInUser", name);
    window.location.href = "index.php";
}

function loginUser() {
    const email = document.getElementById("loginEmail").value;
    if(email) {
        localStorage.setItem("loggedInUser", "Valued Customer");
        window.location.href = "index.php";
    }
}

function addToCart(item, price) {
    localStorage.setItem("item", item);
    localStorage.setItem("price", price);
    window.location.href = "cart.php";
}

function logout() {
    localStorage.removeItem("loggedInUser");
    window.location.href = "login.php";
}