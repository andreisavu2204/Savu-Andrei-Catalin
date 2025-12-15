<?php
// PARTEA PHP: Logica de Validare (Server-Side)
$nume = $email = $mesaj = "";
$nume_err = $email_err = $mesaj_err = "";
$php_success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_valid_php = true;
    
    // Validare Nume (Minim 3 caractere)
    $nume = trim($_POST["nume"]);
    if (strlen($nume) < 3) {
        $nume_err = "Numele este obligatoriu și trebuie să aibă minim 3 caractere.";
        $form_valid_php = false;
    }

    // Validare Email (Format valid)
    $email = trim($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Adresa de email nu este într-un format valid.";
        $form_valid_php = false;
    }

    // Validare Mesaj (Minim 10 caractere)
    $mesaj = trim($_POST["mesaj"]);
    if (strlen($mesaj) < 10) {
        $mesaj_err = "Mesajul este obligatoriu și trebuie să aibă minim 10 caractere.";
        $form_valid_php = false;
    }

    if ($form_valid_php) {
        $php_success_msg = "✅ Validare Server-Side reușită! Mulțumim, " . htmlspecialchars($nume) . "!";
        $nume = $email = $mesaj = "";
    }
}
?>
<?php
// Conexiune la baza de date
$conn = new mysqli("localhost", "user", "password", "contact_form");
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if (strlen($name) < 3) {
        $errors['name'] = "Numele trebuie să aibă minim 3 caractere.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email invalid.";
    }
    if (strlen($message) < 10) {
        $errors['message'] = "Mesajul trebuie să aibă minim 10 caractere.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "Mulțumim, $name! Mesajul tău a fost trimis.";
            $_POST = [];
        } else {
            $success = "Eroare la trimitere.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Formular Contact</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>
    <form id="contactForm" method="POST" action="">
        <label>Nume: <input type="text" name="name" id="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"></label>
        <div id="nameError" class="error"><?= $errors['name'] ?? '' ?></div>
        <br>
        <label>Email: <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label>
        <div id="emailError" class="error"><?= $errors['email'] ?? '' ?></div>
        <br>
        <label>Mesaj: <textarea name="message" id="message"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea></label>
        <div id="messageError" class="error"><?= $errors['message'] ?? '' ?></div>
        <br>
        <button type="submit">Trimite</button>
    </form>
    <div id="successMsg" class="success"></div>

    <script>
        document.getElementById('contactForm').onsubmit = function(e) {
            let valid = true;
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').textContent = '';
            document.getElementById('messageError').textContent = '';
            document.getElementById('successMsg').textContent = '';

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            if (name.length < 3) {
                document.getElementById('nameError').textContent = 'Numele trebuie să aibă minim 3 caractere.';
                valid = false;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('emailError').textContent = 'Email invalid.';
                valid = false;
            }
            if (message.length < 10) {
                document.getElementById('messageError').textContent = 'Mesajul trebuie să aibă minim 10 caractere.';
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            } else {
                document.getElementById('successMsg').textContent = `Mulțumim, ${name}! Mesajul tău: "${message}" a fost trimis.`;
                e.preventDefault();
            }
        };
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exercițiul 1: Formular de Contact</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .error { color: #d9534f; font-size: 0.9em; margin-top: 5px; font-weight: bold; }
        .success { color: #3c763d; background-color: #dff0d8; padding: 15px; border: 1px solid #d6e9c6; border-radius: 4px; margin-bottom: 20px; font-weight: bold; }
        .hidden { display: none; }
        button { background-color: #5bc0de; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Formular de Contact</h2>

    <?php if (!empty($php_success_msg)): ?>
        <div class="success"><?php echo $php_success_msg; ?></div>
    <?php endif; ?>

    <div id="js-success-message" class="success hidden"></div>

    <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        
        <div class="form-group">
            <label for="nume">Nume (minim 3 caractere):</label>
            <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($nume); ?>">
            <div class="error"><?php echo $nume_err; ?></div>
            <div id="nume-error" class="error"></div>
        </div>

        <div class="form-group">
            <label for="email">Email (format valid):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="error"><?php echo $email_err; ?></div>
            <div id="email-error" class="error"></div>
        </div>

        <div class="form-group">
            <label for="mesaj">Mesaj (minim 10 caractere):</label>
            <textarea id="mesaj" name="mesaj" rows="5"><?php echo htmlspecialchars($mesaj); ?></textarea>
            <div class="error"><?php echo $mesaj_err; ?></div>
            <div id="mesaj-error" class="error"></div>
        </div>

        <div class="form-group">
            <button type="submit" name="submit">Trimite</button>
        </div>
    </form>
</div>

<script>
    // PARTEA JAVASCRIPT: Logica de Validare (Client-Side)
    const form = document.getElementById('contactForm');
    const jsSuccessMessage = document.getElementById('js-success-message');

    function validateForm(event) {
        event.preventDefault(); 
        let isValid = true;
        const nume = document.getElementById('nume').value.trim();
        const email = document.getElementById('email').value.trim();
        const mesaj = document.getElementById('mesaj').value.trim();

        document.getElementById('nume-error').textContent = '';
        document.getElementById('email-error').textContent = '';
        document.getElementById('mesaj-error').textContent = '';
        jsSuccessMessage.classList.add('hidden');
        
        if (nume.length < 3) {
            document.getElementById('nume-error').textContent = 'Numele trebuie să aibă minim 3 caractere.';
            isValid = false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('email-error').textContent = 'Introduceți un format de email valid.';
            isValid = false;
        }

        if (mesaj.length < 10) {
            document.getElementById('mesaj-error').textContent = 'Mesajul trebuie să aibă minim 10 caractere.';
            isValid = false;
        }

        if (isValid) {
            jsSuccessMessage.innerHTML = `**Mulțumim, ${nume}!** Mesajul tău: *„${mesaj}”* a fost trimis cu succes.`;
            jsSuccessMessage.classList.remove('hidden');
            form.reset(); 
        }
    }

    form.addEventListener('submit', validateForm);
</script>

</body>
</html>