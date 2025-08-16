<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Patient Enquiries</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #searchInput, #entriesSelect {
      max-width: 200px;
    }
    #pieChart {
      max-width: 400px;
      margin: auto;
    }
  </style>
</head>
<body class="bg-light">

<div class="container my-5">
  <h2 class="text-center mb-4">Patient Enquiries</h2>

  <!-- Pie Chart -->
  <div class="mb-5">
    <canvas id="pieChart"></canvas>
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
      <input type="text" id="searchInput" class="form-control" placeholder="Search enquiries...">
    </div>
  </div>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped" id="enquiryTable">
      <thead class="table-dark">
        <tr>
          <th>Enquiry ID</th>
          <th>Patient Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Enquiry Date</th>
          <th>Symptoms</th>
          <th>Reference</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Mukund Bhoir</td>
          <td>9876543210</td>
          <td>mukund.bhoir@gmail.com</td>
          <td>2025-07-20</td>
          <td>Fever, cough</td>
          <td>Website</td>
          <td>Pending</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Siddhesh Mhatre</td>
          <td>9765432109</td>
          <td>siddhesh.mhatre@yahoo.com</td>
          <td>2025-07-21</td>
          <td>Back pain</td>
          <td>Doctor Reference</td>
          <td>Contacted</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Parth Rotkar</td>
          <td>9654321876</td>
          <td>parth.rotkar@gmail.com</td>
          <td>2025-07-22</td>
          <td>Chest pain</td>
          <td>Facebook Ad</td>
          <td>Closed</td>
        </tr>
        <tr>
          <td>4</td>
          <td>Shubham Sarkhot</td>
          <td>9876343210</td>
          <td>shubham.sarkhot@gmail.com</td>
          <td>2025-07-20</td>
          <td>Fever, cough</td>
          <td>Website</td>
          <td>Pending</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Script for Pie Chart -->
<script>
// Static labels and counts for demo
const statuses = ['Pending', 'Contacted', 'Closed'];
const counts = [2, 1, 1];

const ctx = document.getElementById('pieChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: statuses,
        datasets: [{
            data: counts,
            backgroundColor: ['#f39c12', '#00a65a', '#dd4b39']
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

<!-- Script for Filter & Show Entries -->
<script>
const searchInput = document.getElementById("searchInput");
const entriesSelect = document.getElementById("entriesSelect");
const table = document.getElementById("enquiryTable").getElementsByTagName("tbody")[0];

function filterAndLimitRows() {
  const searchValue = searchInput.value.toLowerCase();
  const maxEntries = entriesSelect.value === "all" ? Infinity : parseInt(entriesSelect.value);
  const rows = table.getElementsByTagName("tr");

  let shownCount = 0;
  for (let i = 0; i < rows.length; i++) {
    const cells = rows[i].getElementsByTagName("td");
    let match = false;

    for (let j = 0; j < cells.length; j++) {
      if (cells[j].innerText.toLowerCase().includes(searchValue)) {
        match = true;
        break;
      }
    }

    if (match && shownCount < maxEntries) {
      rows[i].style.display = "";
      shownCount++;
    } else {
      rows[i].style.display = "none";
    }
  }
}

searchInput.addEventListener("keyup", filterAndLimitRows);
entriesSelect.addEventListener("change", filterAndLimitRows);
filterAndLimitRows();
</script>

</body>
</html>
