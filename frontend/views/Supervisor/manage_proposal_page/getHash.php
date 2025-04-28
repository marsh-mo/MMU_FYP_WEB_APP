<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    echo "<strong>Original Password:</strong> " . htmlspecialchars($password) . "<br>";
    echo "<strong>Hashed Password:</strong> " . $hashed_password;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hash Password Generator</title>
</head>
<body>
    <h2>Enter a Password to Hash</h2>
    <form method="POST">
        <input type="text" name="password" required>
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>