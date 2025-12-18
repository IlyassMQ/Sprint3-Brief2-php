<?php
require 'config.php';

// GET DOCTOR DATA
if (!isset($_GET['doctor_id'])) {
    header('Location: doctors.php');
    exit;
}

$doctor_id = (int) $_GET['doctor_id'];

$query = "SELECT * FROM doctors WHERE doctor_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $doctor_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$doctor = mysqli_fetch_assoc($result);

if (!$doctor) {
    header('Location: doctors.php');
    exit;
}

// GET ALL DEPARTMENTS FOR SELECT
$departmentsQuery = "SELECT department_id, name FROM departments ORDER BY name";
$departmentsResult = mysqli_query($conn, $departmentsQuery);

// UPDATE DOCTOR
if (isset($_POST['update_doctor'])) {
    $first_name    = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name     = mysqli_real_escape_string($conn, $_POST['last_name']);
    $department_id = (int) $_POST['department_id'];
    $phone         = mysqli_real_escape_string($conn, $_POST['phone']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);

    $updateQuery = "UPDATE doctors SET first_name = ?, last_name = ?, department_id = ?, phone = ?, email = ? WHERE doctor_id = ?";

    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssissi", $first_name, $last_name, $department_id, $phone, $email, $doctor_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: doctors.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Doctor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
    <h2 class="text-xl font-semibold mb-4">Update Doctor</h2>

    <form method="POST" class="grid grid-cols-1 gap-4">

        <input type="text" name="first_name"
               value="<?= $doctor['first_name'] ?>"
               class="p-3 border rounded-lg" required>

        <input type="text" name="last_name"
               value="<?= $doctor['last_name'] ?>"
               class="p-3 border rounded-lg" required>

        <select name="department_id" class="p-3 border rounded-lg" required>
            <option value="">Select Department</option>
            <?php while ($dept = mysqli_fetch_assoc($departmentsResult)) { ?>
                <option value="<?= $dept['department_id'] ?>" 
                    <?php if ($doctor['department_id'] == $dept['department_id']) echo 'selected'; ?>>
                    <?= $dept['name'] ?>
                </option>
            <?php } ?>
        </select>

        <input type="text" name="phone"
               value="<?= $doctor['phone'] ?>"
               class="p-3 border rounded-lg">

        <input type="email" name="email"
               value="<?= $doctor['email'] ?>"
               class="p-3 border rounded-lg">

        <div class="flex gap-3">
            <a href="doctors.php" class="w-1/2 text-center bg-gray-400 text-white py-3 rounded-lg hover:bg-gray-500">
                Cancel
            </a>

            <button type="submit" name="update_doctor"
                class="w-1/2 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                Update Doctor
            </button>
        </div>
    </form>
</div>

</body>
</html>
