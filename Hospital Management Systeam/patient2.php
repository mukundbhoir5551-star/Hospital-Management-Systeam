<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patient Payment Records</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .container {
      margin-top: 50px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    #searchInput, #entriesSelect {
      max-width: 200px;
    }
    #statusBarChart {
      max-height: 350px;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container">
    <h2 class="text-center mb-4">Patient Payment Records</h2>

    <!-- Controls -->
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
        <input type="text" id="searchInput" class="form-control" placeholder="Search payments...">
      </div>
    </div>

    <!-- Table and Bar Chart Side by Side -->
    <div class="row">
      <!-- Table -->
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped" id="paymentTable">
            <thead class="table-dark">
              <tr>
                <th>Payment ID</th>
                <th>Patient Name</th>
                <th>Patient ID</th>
                <th>Amount (₹)</th>
                <th>Payment Date</th>
                <th>Method</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>PMT001</td>
                <td>Mukund Bhoir</td>
                <td>1</td>
                <td>1500</td>
                <td>2025-08-01</td>
                <td>UPI</td>
                <td><span class="badge bg-success">Paid</span></td>
              </tr>
              <tr>
                <td>PMT002</td>
                <td>Siddhesh Mhatre</td>
                <td>2</td>
                <td>800</td>
                <td>2025-08-02</td>
                <td>Cash</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
              </tr>
              <tr>
                <td>PMT003</td>
                <td>Parth Rotkar</td>
                <td>3</td>
                <td>1200</td>
                <td>2025-08-04</td>
                <td>Credit Card</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
              </tr>
              <tr>
                <td>PMT004</td>
                <td>Shubham Sarkhot</td>
                <td>4</td>
                <td>1800</td>
                <td>2025-08-07</td>
                <td>Credit Card</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Status Bar Graph -->
      <div class="col-md-4">
        <canvas id="statusBarChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Script for Filter & Show Entries -->
  <script>
    const searchInput = document.getElementById("searchInput");
    const entriesSelect = document.getElementById("entriesSelect");
    const table = document.getElementById("paymentTable").getElementsByTagName("tbody")[0];

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
      updateStatusChart(); // Update bar chart on filter
    }

    searchInput.addEventListener("keyup", filterAndLimitRows);
    entriesSelect.addEventListener("change", filterAndLimitRows);

    // Chart.js Bar Chart for Status
    const ctx = document.getElementById("statusBarChart").getContext("2d");
    let statusChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Paid", "Pending"],
        datasets: [{
          label: "Number of Payments",
          data: [0, 0],
          backgroundColor: ["#28a745", "#ffc107"]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    function updateStatusChart() {
      let paidCount = 0;
      let pendingCount = 0;
      const rows = table.getElementsByTagName("tr");
      for (let row of rows) {
        if (row.style.display !== "none") {
          const statusCell = row.getElementsByTagName("td")[6];
          if (statusCell.innerText.includes("Paid")) {
            paidCount++;
          } else if (statusCell.innerText.includes("Pending")) {
            pendingCount++;
          }
        }
      }
      statusChart.data.datasets[0].data = [paidCount, pendingCount];
      statusChart.update();
    }

    // Initialize display
    filterAndLimitRows();
  </script>

</body>
</html>
