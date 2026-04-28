const BASE_URL = "http://localhost/Basdat/kelompok_api/index.php";

document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const res = await fetch(`${BASE_URL}?action=login`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            username,
            password
        })
    });

    const data = await res.json();

    if (data.status) {
        localStorage.setItem("user", JSON.stringify(data.data));
        window.location.href = "voting.html";
    } else {
        document.getElementById("msg").innerText = data.message;
    }
});