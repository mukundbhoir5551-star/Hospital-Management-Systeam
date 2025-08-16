<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patient Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #searchInput, #entriesSelect {
      max-width: 200px;
    }
    #addressChart {
      max-width: 400px;
      margin: auto;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container my-5">
    <h2 class="text-center mb-4">Patient Registration Table</h2>

    <!-- Address Pie Chart -->
    <div class="mb-5">
      <h4 class="text-center">Patients by Address</h4>
      <canvas id="addressChart"></canvas>
    </div>

    <!-- Controls Row -->
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="entriesSelect" class="form-label">Show entries:</label>
        <select id="entriesSelect" class="form-select">
          <option value="1">1</option>
          <option value="2" selected>2</option>
          <option value="3">3</option>
          <option value="all">All</option>
        </select>
      </div>
      <div class="col-md-6 d-flex align-items-end justify-content-end">
        <input type="text" id="searchInput" class="form-control" placeholder="Search patients...">
      </div>
    </div>

    <!-- Patient Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped" id="patientTable">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Registration Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mukund Bhoir</td>
            <td>17</td>
            <td>Male</td>
            <td>9876543210</td>
            <td>mukund.bhoir@gmail.com</td>
            <td>Mumbai, MH</td>
            <td>2025-08-01</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Siddhesh Mhatre</td>
            <td>15</td>
            <td>Male</td>
            <td>9765432109</td>
            <td>siddhesh.mhatre@yahoo.com</td>
            <td>Pune, MH</td>
            <td>2025-08-03</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Parth Rotkar</td>
            <td>16</td>
            <td>Male</td>
            <td>9654321876</td>
            <td>parth.rotkar@gmail.com</td>
            <td>Nashik, MH</td>
            <td>2025-08-04</td>
          </tr>
          <tr>
            <td>4</td>
            <td>Shubham Sarkhot</td>
            <td>17</td>
            <td>Male</td>
            <td>9876343210</td>
            <td>shubham.sarkhot@gmail.com</td>
            <td>Mumbai, MH</td>
            <td>2025-08-01</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    const searchInput = document.getElementById("searchInput");
    const entriesSelect = document.getElementById("entriesSelect");
    const table = document.getElementById("patientTable").getElementsByTagName("tbody")[0];

    function filterAndLimitRows() {
      const filter = searchInput.value.toLowerCase();
      const maxEntries = entriesSelect.value === "all" ? Infinity : parseInt(entriesSelect.value);
      const rows = table.getElementsByTagName("tr");

      let shown = 0;
      for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
          if (cells[j].innerText.toLowerCase().includes(filter)) {
            match = true;
            break;
          }
        }

        if (match && shown < maxEntries) {
          rows[i].style.display = "";
          shown++;
        } else {
          rows[i].style.display = "none";
        }
      }
    }

    searchInput.addEventListener("keyup", filterAndLimitRows);
    entriesSelect.addEventListener("change", filterAndLimitRows);
    filterAndLimitRows();

    // ===== Pie Chart Data =====
    const addresses = {};
    const rows = table.getElementsByTagName("tr");
    for (let i = 0; i < rows.length; i++) {
      const addressCell = rows[i].getElementsByTagName("td")[6];
      if (addressCell) {
        const city = addressCell.innerText.split(",")[0].trim();
        addresses[city] = (addresses[city] || 0) + 1;
      }
    }

    const ctx = document.getElementById('addressChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: Object.keys(addresses),
        datasets: [{
          data: Object.values(addresses),
          backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });
  </script>

</body>
</html>
