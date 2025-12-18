<?php
include "config.php";
include "addDoctor.php";
include "deleteDoctor.php";
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
            <a href="patients.php" class="block p-3 rounded-lg hover:bg-gray-700">Patients</a>
            <a href="departement.php" class="block p-3 rounded-lg hover:bg-gray-700">Departements</a>
            <a href="doctors.php" class="block p-3 rounded-lg bg-gray-700">Doctors</a>
            
        </nav>
    </aside>

    
    <main class="flex-1 ml-64 overflow-y-auto">

        <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-xl font-semibold text-gray-800">Doctors</h1>
        </header>

        <!-- PAGE CONTENT -->
        <div class="p-6 space-y-8">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Add Doctors</h2>

                <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <input type="text" name="first_name" placeholder="First Name" required
                           class="p-3 border rounded-lg">

                    <input type="text" name="last_name" placeholder="Last Name" required
                           class="p-3 border rounded-lg">

                    <!-- DEPAAAAAARTEMENT -->
                     <?php 
                        $departmentsQuery = "SELECT department_id, name FROM departments ORDER BY name";
                        $departmentsResult = mysqli_query($conn, $departmentsQuery);
                        ?>
                        <select name="department_id" required class="p-3 border rounded-lg">
                            <option value="">Department</option>
                            <?php while ($dept = mysqli_fetch_assoc($departmentsResult)) { ?>
                                <option value="<?= $dept['department_id']; ?>">
                                    <?= $dept['name']; ?>
                                </option>
                    <?php } ?>
                        </select>


                     <!-- DEPAAAAAARTEMENT -->


                    <input type="text" name="phone" placeholder="Phone"
                           class="p-3 border rounded-lg">

                    <input type="email" name="email" placeholder="Email"
                           class="p-3 border rounded-lg">

                    <button type="submit" name="add_doctor"
                            class="bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 md:col-span-2">
                        Add Doctors
                    </button>
                </form>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Doctors List</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border text-center">ID</th>
                                <th class="p-3 border text-center">First Name</th>
                                <th class="p-3 border text-center">Last Name</th>
                                <th class="p-3 border text-center">Phone</th>
                                <th class="p-3 border text-center">Departement</th>
                                <th class="p-3 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $doctorQuery = " SELECT d.*, dept.name AS department_name  FROM doctors d LEFT JOIN departments dept ON d.department_id = dept.department_id ORDER BY d.doctor_id DESC ";
                            
                            $doctorResult = mysqli_query($conn, $doctorQuery);
                            while ($doctor = mysqli_fetch_assoc($doctorResult)) { ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border text-center"><?= $doctor['doctor_id'] ?></td>
                                    <td class="p-3 border text-center"><?= $doctor['first_name'] ?></td>
                                    <td class="p-3 border text-center"><?= $doctor['last_name'] ?></td>
                                    <td class="p-3 border text-center"><?= $doctor['phone'] ?></td>
                                    <td class="p-3 border text-center"><?= $doctor['department_name'] ?></td>
                                     <td class="p-3 border text-center space-x-4">
                                            <a href="deleteDoctor.php?doctor_id=<?= $doctor['doctor_id']?>"
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                                Delete
                                            </a>
                                            <a href="updateDoctor.php?doctor_id=<?= $doctor['doctor_id']?>"
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
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


        </div>
    </main>
</div>

</body>
</html>
