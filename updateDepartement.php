<?php
require 'config.php';

// GET DEPARTMENT DATA
if (!isset($_GET['departement_id'])) {
    header('Location: departement.php');
    exit;
}

$departement_id = (int) $_GET['departement_id'];

$query = "SELECT * FROM departments WHERE department_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $departement_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$departement = mysqli_fetch_assoc($result);

if (!$departement) {
    header('Location: departement.php');
    exit;
}

// UPDATE DEPARTMENT
if (isset($_POST['update_departement'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $updateQuery = "UPDATE departments SET name = ?, description = ? WHERE department_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $departement_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: departement.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Departement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    
<div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
    <h2 class="text-xl font-semibold mb-4">Update Departement</h2>

    <form method="POST" class="grid grid-cols-1 gap-4">

        <input type="text" name="name" placeholder="name" value="<?= $departement['name'] ?>" class="p-3 border rounded-lg" required>

        <input type="text" name="description" placeholder="description" value="<?= $departement['description'] ?>" class="p-3 border rounded-lg" required>

        <div class="flex gap-3">
            <a href="departement.php" class="w-1/2 text-center bg-gray-400 text-white py-3 rounded-lg hover:bg-gray-500">
            Cancel
            </a>

            <button type="submit" name="update_departement"
                class="w-1/2 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                Update Departement
            </button>
        </div>
    </form>
</div>

</body>
</html>
