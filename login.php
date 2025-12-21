<?php
session_start();
require 'config.php';

/* IF ALREADDY LOGGED GO DIRECT TO INDEX */
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT id, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;

            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-indigo-600 mb-6">Login</h2>

        <?php if ($error): ?>
            <p class="text-red-500 text-center mb-4"><?= $error ?></p>
        <?php endif; ?>


        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="username">Username</label>
                <input  type="text"  name="username"  id="username" placeholder="Username" required class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required class="w-full px-4 py-3 border rounded-lg">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold">
                Login
            </button>
        </form>
    </div>

</body>
</html>

