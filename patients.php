<?php
include "config.php";
include "addPatient.php";
include "deletePatient.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen">

    
    <aside class="w-64 bg-gray-800 text-white flex flex-col p-4 fixed h-full">
        <div class="text-2xl font-bold mb-6 text-indigo-400">Dashboard</div>

        <nav class="space-y-2">
            <a href="index.php" class="block p-3 rounded-lg hover:bg-gray-700">Home</a>
            <a href="patients.php" class="block p-3 rounded-lg bg-gray-700">Patients</a>
            <a href="departement.php" class="block p-3 rounded-lg hover:bg-gray-700">Departements</a>
            <a href="doctors.php" class="block p-3 rounded-lg hover:bg-gray-700">Doctors</a>
        </nav>
    </aside>

    <main class="flex-1 ml-64 overflow-y-auto">

      
        <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-xl font-semibold text-gray-800">Patients</h1>
        </header>

        <div class="p-6 space-y-8">

            
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Add Patient</h2>

                <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <input type="text" name="first_name" placeholder="First Name" required
                           class="p-3 border rounded-lg">

                    <input type="text" name="last_name" placeholder="Last Name" required
                           class="p-3 border rounded-lg">

                    <select name="gender" required class="p-3 border rounded-lg">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>

                    <input type="text" name="phone" placeholder="Phone"
                           class="p-3 border rounded-lg">

                    <input type="email" name="email" placeholder="Email"
                           class="p-3 border rounded-lg">

                    <button type="submit" name="add_patient"
                            class="bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 md:col-span-2">
                        Add Patient
                    </button>
                </form>
            </div>

            <!-- PATIENTS TABLE -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Patients List</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border text-center">ID</th>
                                <th class="p-3 border text-center">First Name</th>
                                <th class="p-3 border text-center">Last Name</th>
                                <th class="p-3 border text-center">Gender</th>
                                <th class="p-3 border text-center">Phone</th>
                                <th class="p-3 border text-center">Email</th>
                                <th class="p-3 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $patientsQuery = "SELECT * FROM patients ORDER BY patient_id DESC";
                            $patientsResult = mysqli_query($conn, $patientsQuery);
                            while ($patient = mysqli_fetch_assoc($patientsResult)) { ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border text-center"><?= $patient['patient_id'] ?></td>
                                    <td class="p-3 border text-center"><?= $patient['first_name'] ?></td>
                                    <td class="p-3 border text-center"><?= $patient['last_name'] ?></td>
                                    <td class="p-3 border text-center"><?= $patient['gender'] ?></td>
                                    <td class="p-3 border text-center"><?= $patient['phone'] ?></td>
                                    <td class="p-3 border text-center"><?= $patient['email'] ?></td>
                                     <td class="p-3 border text-center space-x-4">
                                            <a href="deletePatient.php?patient_id=<?= $patient['patient_id']?>"
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                                Delete
                                            </a>
                                            <a href="updatePatient.php?patient_id=<?= $patient['patient_id'] ?>"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                                Update
                                            </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>
