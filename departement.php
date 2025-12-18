<?php
include "config.php";
include "addDepartement.php";

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
            <a href="departement.php" class="block p-3 rounded-lg bg-gray-700">Departements</a>
            <a href="doctors.php" class="block p-3 rounded-lg hover:bg-gray-700">Doctors</a>
            
        </nav>
    </aside>

    
    <main class="flex-1 ml-64 overflow-y-auto">

        <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-xl font-semibold text-gray-800">Patients</h1>
        </header>

        <!-- PAGE CONTENT -->
        <div class="p-6 space-y-8">

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Add Departement</h2>

                <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <input type="text" name="name" placeholder="Departement Name" required
                           class="p-3 border rounded-lg">

                    <input type="text" name="description" placeholder="Departement Description" required
                           class="p-3 border rounded-lg">

                    <button type="submit" name="add_departement"
                            class="bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 md:col-span-2">
                        Add Departements
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Departements List</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border text-center">ID</th>
                                <th class="p-3 border text-center">Name</th>
                                <th class="p-3 border text-center">Description</th>
                                <th class="p-3 border text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $departementQuery = "SELECT * FROM departments ORDER BY department_id DESC";
                            $departementResult = mysqli_query($conn, $departementQuery);
                            while ($departement = mysqli_fetch_assoc($departementResult)) { ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border text-center"><?= $departement['department_id'] ?></td>
                                    <td class="p-3 border text-center"><?= $departement['name'] ?></td>
                                    <td class="p-3 border text-center"><?= $departement['description'] ?></td> 
                                     <td class="p-3 border text-center space-x-4">
                                            <a href="deleteDepartement.php?department_id=<?= $departement['department_id'] ?>" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</a>

                                            
                                            <a href="updateDepartement.php?departement_id=<?= $departement['department_id']?>"
                                            class="bg-green-600 text-white px-4 py-2 rounded-lg">
                                                Update
                                            </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>
</div>

</body>
</html>
