<?php
include "config.php";
// PATIENT DATA
$query_patient = "SELECT COUNT(*) AS total_patients FROM patients";
$result_patient = mysqli_query($conn, $query_patient);
$row_patient = mysqli_fetch_assoc($result_patient);
$totalPatient = $row_patient['total_patients'];
// DOCTORS DATA
$query_doctor = "SELECT COUNT(*) AS total_doctors FROM doctors";
$result_doctor = mysqli_query($conn, $query_doctor);
$row_doctor = mysqli_fetch_assoc($result_doctor);
$totalDoctor = $row_doctor['total_doctors'];
// DPARTEMENT DATA
$query_depar = "SELECT COUNT(*) AS total_depar FROM departments";
$result_depar = mysqli_query($conn, $query_depar);
$row_depar = mysqli_fetch_assoc($result_depar);
$totalDepar = $row_depar['total_depar'];

// LATEST PATIENT
$query_latest_patients = "SELECT * FROM patients ORDER BY patient_id DESC LIMIT 10";
$result_latest_patients = mysqli_query($conn, $query_latest_patients);

?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen">
        <aside class="sidebar w-64 bg-gray-800 text-white flex flex-col p-4 fixed h-full border-r">
            <div class="text-2xl font-bold mb-6 text-indigo-400">Dashboard</div>

            <nav class="space-y-2">
                <a href="index.php" class="block p-3 rounded-lg bg-gray-700 hover:bg-gray-600 font-medium">
                    <i class="fas fa-home mr-3"></i> Home
                </a>
                <a href="patients.php" class="block p-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-chart-line mr-3"></i> Patients
                </a>

                <a href="departement.php" class="block p-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-cog mr-3"></i> Departements
                </a>

                <a href="doctors.php" class="block p-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-users mr-3"></i> Doctors
                </a>
                
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto ml-64">
            <hea    der class="shadow-md p-4 flex justify-between items-center sticky top-0 z-10 border-b">
                <h1 class="text-xl font-semibold">Overview</h1>
            </hea>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="p-6 rounded-xl shadow-lg bg-white h-[200px]">
                        <p class="text-sm font-medium text-gray-500">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            <?php echo $totalPatient; ?>
                        </p>
                    </div>
                    <div class="p-6 rounded-xl shadow-lg bg-white h-[200px]">
                        <p class="text-sm font-medium text-gray-500">Total Doctors</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            <?php echo $totalDoctor; ?>
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg h-[200px]">
                        <p class="text-sm font-medium text-gray-500">Total Departements</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">
                            <?php echo $totalDepar; ?>
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>