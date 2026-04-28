const BASE_URL = "http://localhost/Basdat/kelompok_api/index.php";
const user = JSON.parse(localStorage.getItem("user"));

let step = "osis"; // osis -> mpk

async function loadKandidat() {
    const res = await fetch(`${BASE_URL}?action=view_kandidat`);
    const result = await res.json();

    render(result.data);
}

function render(data) {
    const container = document.getElementById("osis");
    container.innerHTML = `<h3>${step.toUpperCase()}</h3>`;

    data
        .filter(k => k.jenis === step)
        .forEach(k => {
            const html = `
                <div>
                    <b>${k.ketua} & ${k.wakil}</b>
                    <p>${k.visi}</p>
                    <button onclick="vote(${k.id_kandidat})">Pilih</button>
                    <hr>
                </div>
            `;
            container.innerHTML += html;
        });
}

loadKandidat();

async function vote(id_kandidat) {
    const res = await fetch(`${BASE_URL}?action=voting`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id_user: user.id_users,
            id_kandidat,
            id_periode: 1
        })
    });

    const data = await res.json();
    alert(data.message);

    if (data.status) {
        if (step === "osis") {
            // lanjut ke MPK
            step = "mpk";
            alert("Lanjut pilih MPK");
            loadKandidat();
        } else {
            // selesai
            alert("Voting selesai, anda akan logout");

            localStorage.removeItem("user");
            window.location.href = "login.html";
        }
    }
}