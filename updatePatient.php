<?php
require 'config.php';


//    GET PATIENT DATA

if (!isset($_GET['patient_id'])) {
    header('Location: patients.php');
    exit;
}

$patient_id = (int) $_GET['patient_id'];

$query = "SELECT * FROM patients WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    header('Location: patients.php');
    exit;
}

//    UPDATE PATIENT
if (isset($_POST['update_patient'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);

    $updateQuery = "update patients set first_name = ?, last_name = ?, gender = ?, phone = ?, email = ? WHERE patient_id = ?";

    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt,"sssssi",$first_name,$last_name,$gender,$phone,$email,$patient_id);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: patients.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Patient</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    
<div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
    <h2 class="text-xl font-semibold mb-4">Update Patient</h2>

    <form method="POST" class="grid grid-cols-1 gap-4">

        <input type="text" name="first_name"
               value="<?= $patient['first_name'] ?>"
               class="p-3 border rounded-lg" required>

        <input type="text" name="last_name"
               value="<?= $patient['last_name'] ?>"
               class="p-3 border rounded-lg" required>

        <select name="gender" class="p-3 border rounded-lg" required>
            <option value="Male" <?php if ($patient['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($patient['gender'] == 'Female') echo 'selected'; ?>>Female</option>
        </select>


        <input type="text" name="phone"
               value="<?= $patient['phone'] ?>"
               class="p-3 border rounded-lg">

        <input type="email" name="email"
               value="<?= $patient['email'] ?>"
               class="p-3 border rounded-lg">

        <div class="flex gap-3">
            <a href="patients.php" class="w-1/2 text-center bg-gray-400 text-white py-3 rounded-lg hover:bg-gray-500">
            Cancel
        </a>

        <button type="submit" name="update_patient"
            class="w-1/2 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                Update Patient
        </button>
    </div>

    </form>
</div>

</body>
</html>
