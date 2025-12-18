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

// DOCTORS PER DEPARTMENT
$query_doc_dep = "
    SELECT d.name, COUNT(doc.doctor_id) AS total_doctors
    FROM departments d
    LEFT JOIN doctors doc ON doc.department_id = d.department_id
    GROUP BY d.department_id
";

$result_doc_dep = mysqli_query($conn, $query_doc_dep);

$depNames = [];
$docCounts = [];

while ($row = mysqli_fetch_assoc($result_doc_dep)) {
    $depNames[] = $row['name'];
    $docCounts[] = $row['total_doctors'];
}


// LATEST PATIENT
$query_latest_patients = "SELECT * FROM patients ORDER BY patient_id DESC LIMIT 3";
$result_latest_patients = mysqli_query($conn, $query_latest_patients);

?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <header class="shadow-md p-4 flex justify-between items-center sticky top-0 z-10 border-b bg-gray-100">
                <h1 class="text-xl font-semibold">Dashboard</h1>
            </header>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="p-6 rounded-xl shadow-lg bg-red-500 h-[200px] text-white">
                        <p class="text-xl font-medium">Total Patients</p>
                        <p class="text-6xl font-bold mt-1">
                            <?php echo $totalPatient; ?>
                        </p>
                    </div>
                    <div class="p-6 rounded-xl shadow-lg bg-green-500 h-[200px] text-white">
                        <p class="text-xl font-medium">Total Doctors</p>
                        <p class="text-6xl font-bold mt-1">
                            <?php echo $totalDoctor; ?>
                        </p>
                    </div>
                    <div class="bg-yellow-500 p-6 rounded-xl shadow-lg h-[200px] text-white">
                        <p class="text-xl font-medium">Total Departements</p>
                        <p class="text-6xl font-bold  mt-1">
                            <?php echo $totalDepar; ?>
                        </p>
                    </div>                   
                  </div>
                  <div class="p-6 bg-white rounded-xl shadow-lg mb-6">
                      <h2 class="text-lg font-semibold mb-4">Latest Patients</h2>
                      <div class="overflow-x-auto">
                          <table class="w-full border-collapse">
                              <thead>
                                  <tr class="bg-gray-100">
                                      <th class="p-3 border text-left">ID</th>
                                      <th class="p-3 border text-left">First Name</th>
                                      <th class="p-3 border text-left">Last Name</th>
                                      <th class="p-3 border text-left">Email</th>
                                      <th class="p-3 border text-left">Phone</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php while ($patient = mysqli_fetch_assoc($result_latest_patients)) { ?>
                                      <tr class="hover:bg-gray-50">
                                          <td class="p-3 border"><?= $patient['patient_id'] ?></td>
                                          <td class="p-3 border"><?= $patient['first_name'] ?></td>
                                          <td class="p-3 border"><?= $patient['last_name'] ?></td>
                                          <td class="p-3 border"><?= $patient['email'] ?></td>
                                          <td class="p-3 border"><?= $patient['phone'] ?></td>
                                      </tr>
                                  <?php } ?>
                              </tbody>
                          </table>
                      </div>
                  </div>


                    <div class="flex gap-6">
                      <div class="bg-white p-4 rounded-xl shadow-lg w-1/2 h-[380px]">
                          <h2 class="text-md font-semibold mb-2">Overview</h2>
                          <canvas id="totalChart" class="h-full"></canvas>
                      </div>

                      <div class="bg-white p-4 rounded-xl shadow-lg w-1/2 h-[380px]">
                          <h2 class="text-md font-semibold mb-2">Doctors per Department</h2>
                          <canvas id="doctorDeptChart" class="h-full"></canvas>
                      </div>

                    </div>
                  </div>
                </div>       
            </div>
        </main>
    </div>
                  <script>
                    const ctx = document.getElementById('totalChart');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Patient', 'Doctor', 'Departement'],
                            datasets: [{
                                label: 'Total',
                                data: [<?php echo $totalPatient; ?>, <?php echo $totalDoctor; ?>, <?php echo $totalDepar; ?>],
                                borderWidth: 1,
                                backgroundColor: [
                                    '#ef4444', 
                                    '#22c55e', 
                                    '#eab308'  
                                ]
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>


                  <!-- CHART DOCTORS IN DEPARTEMENT -->
                  <script>
                const ctx2 = document.getElementById('doctorDeptChart');

                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($depNames); ?>,
                        datasets: [{
                            label: 'Doctors',
                            data: <?php echo json_encode($docCounts); ?>,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                        stepSize: 1,
                        precision: 0
                      }
                            }
                        }
                    }
                });
            </script>

</body>
</html>