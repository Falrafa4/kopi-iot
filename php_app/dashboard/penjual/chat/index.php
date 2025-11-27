<?php
include "../../config/db.php";
if (isset($_GET['id'])) {
    $id_pembeli = $_GET['id'];
} else {
    // Jika tidak ada id_pembeli, arahkan kembali ke halaman sebelumnya atau tampilkan pesan error
    header("Location: /");
    exit();
}

// data pembeli bisa diambil dari database jika diperlukan
$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_pembeli);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>
<!-- INI HALAMAN CHAT KE PENJUAL -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPI IoT - Chat ke Pembeli</title>
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/chat.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <main>
        <div class="header">
            <a href="../" class="btn-primary back">
                <svg width="20" height="16" viewBox="0 0 40 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="icon" d="M17.3789 29.9453C16.8539 30.4703 16.1418 30.7651 15.3993 30.7651C14.6569 30.7651 13.9448 30.4703 13.4197 29.9453L0.81974 17.3453C0.294823 16.8203 -6.10352e-05 16.1082 -6.10352e-05 15.3657C-6.10352e-05 14.6233 0.294823 13.9112 0.81974 13.3861L13.4197 0.786137C13.9478 0.276093 14.6551 -0.00613022 15.3893 0.000247955C16.1234 0.00662804 16.8257 0.301102 17.3448 0.820244C17.864 1.33939 18.1584 2.04166 18.1648 2.77581C18.1712 3.50996 17.889 4.21725 17.3789 4.74533L9.79934 12.5657L36.3993 12.5657C37.1419 12.5657 37.8541 12.8607 38.3792 13.3858C38.9043 13.9109 39.1993 14.6231 39.1993 15.3657C39.1993 16.1083 38.9043 16.8205 38.3792 17.3456C37.8541 17.8707 37.1419 18.1657 36.3993 18.1657L9.79934 18.1657L17.3789 25.9861C17.9039 26.5112 18.1987 27.2233 18.1987 27.9657C18.1987 28.7082 17.9039 29.4203 17.3789 29.9453Z" fill="#FFFAF1" />
                </svg>
            </a>
            <h2>Chat Kepada <?= htmlspecialchars($data['nama']) ?></h2>
        </div>

        <div class="container-chat" id="containerChat">
            <div id="box"></div>
            <input type="hidden" id="pengirim" value="1"> <!-- 2 = pembeli -->
            <input type="hidden" id="penerima" value="<?= $id_pembeli ?>"> <!-- 1 = penjual -->

            <div class="chat-box">
                <input type="text" id="msg" placeholder="Ketik pesan..." onkeypress="if(event.key === 'Enter') sendMsg()">
                <button onclick="sendMsg()">
                    <svg width="25" height="15" viewBox="0 0 69 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 57.3333V0L68.0833 28.6667L0 57.3333ZM7.16667 46.5833L49.6292 28.6667L7.16667 10.75V23.2917L28.6667 28.6667L7.16667 34.0417V46.5833Z" fill="#FFFAF1" />
                    </svg>
                </button>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <?php //include '../../includes/footer.php'; 
    ?>
    <!-- FOOTER END -->

    <script src="/assets/js/script.js"></script>
    <script>
        setInterval(loadChat, 1000);

        const box = document.getElementById("box");

        function loadChat() {
            const isAtBottom = box.scrollTop + box.clientHeight >= box.scrollHeight - 10;
            fetch("/chat/chat_load.php")
                .then(r => r.json())
                .then(data => {
                    // let box = document.getElementById("box");
                    box.innerHTML = "";

                    let me = document.getElementById("pengirim").value;

                    console.log(data);

                    data.forEach(c => {
                        let div = document.createElement("div");
                        div.classList.add("msg");

                        if (c.id_pengirim == me) div.classList.add("me");
                        else div.classList.add("other");

                        div.innerHTML = `<b>${c.id_pengirim == 1 ? 'Penjual' : 'Pembeli'}:</b> <p>${c.pesan}</p>`;
                        box.appendChild(div);
                    });

                    if (isAtBottom) {
                        box.scrollTop = box.scrollHeight; // auto scroll
                    }
                });
        }

        function sendMsg() {
            let msg = document.getElementById("msg").value;

            if (msg.trim() == "") return;

            let form = new FormData();
            form.append("pengirim", document.getElementById("pengirim").value);
            form.append("penerima", document.getElementById("penerima").value);
            form.append("pesan", msg);

            fetch("/chat/chat_send.php", {
                    method: "POST",
                    body: form
                })
                .then(() => {
                    document.getElementById("msg").value = "";
                });
        }
    </script>
</body>

</html>