<?php
/*
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/
include '../alice/include/mysql.pdo.php';
// Recupera i dati dal form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];

    // Query SQL per inserire i dati
    $sql = "INSERT INTO scrivici (nome, cognome, email, newsletter, messaggio) VALUES (:nome, :cognome, :email, :newsletter, :messaggio)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cognome', $cognome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':newsletter', $_POST['newsletter']);
    $stmt->bindParam(':messaggio', $_POST['messaggio']);
    $stmt->execute();
    #header('location: index.html');

    // 📧 Email di notifica interna
    $to = "info@nina.watch";
    $subject = "nuovo inserimento nel form mostra incomputabile";

    $message = "Nuovo inserimento nel form:\n\n"
             . "Nome: $nome\n"
             . "Cognome: $cognome\n"
             . "newsletter: $newsletter\n"
             . "Messaggio: $messaggio\n"
             . "Email utente: $email\n";

    $headers = "From: sito@nina.watch";

    mail($to, $subject, $message, $headers);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Conferma invio</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        button {
            margin-top: 20px;
            padding: 10px 25px;
            font-size: 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="popup">
        <h2>Invio completato</h2>
        <p>La tua proposta è stata inviata correttamente.<br>
        Grazie per averci scritto.</p>
        <button onclick="redirect()">OK</button>
    </div>
</div>

<script>
function redirect() {
    window.location.href = "index.html";
}
</script>

</body>
</html>
