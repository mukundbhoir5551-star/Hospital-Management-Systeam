<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patient Feedback</title>
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
    /* Medium size chart */
    #barChart {
      max-width: 600px;
      height: 350px;
      margin: 30px auto;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container">
    <h2 class="text-center mb-4">Patient Feedback</h2>

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
        <input type="text" id="searchInput" class="form-control" placeholder="Search feedback...">
      </div>
    </div>

    <!-- Feedback Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped" id="feedbackTable">
        <thead class="table-dark">
          <tr>
            <th>Patient Name</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Comments</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Mukund Bhoir</td>
            <td>mukund.bhoir@gmail.com</td>
            <td>5</td>
            <td>Excellent service and care.</td>
          </tr>
          <tr>
            <td>Siddhesh Mhatre</td>
            <td>siddhesh.mhatre@outlook.com</td>
            <td>5</td>
            <td>Very professional and friendly doctors.</td>
          </tr>
          <tr>
            <td>Parth Rotkar</td>
            <td>parth.rotkar@yahoo.com</td>
            <td>4</td>
            <td>Good staff, clean environment.</td>
          </tr>
          <tr>
            <td>Shubham Sarkhot</td>
            <td>shubham.sarkhot@gmail.com</td>
            <td>3</td>
            <td>Average experience, could improve wait time.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Medium Size Bar Chart -->
    <canvas id="barChart"></canvas>
  </div>

  <!-- Script -->
  <script>
    const searchInput = document.getElementById("searchInput");
    const entriesSelect = document.getElementById("entriesSelect");
    const table = document.getElementById("feedbackTable").getElementsByTagName("tbody")[0];

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
    filterAndLimitRows(); // Initialize

    // ====== Bar Chart Setup ======
    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Mukund', 'Siddhesh', 'Parth', 'Shubham'],
        datasets: [{
          label: 'Patient Ratings',
          data: [5, 5, 4, 3],
          backgroundColor: ['#4caf50', '#2196f3', '#ff9800', '#f44336']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          title: {
            display: true,
            text: 'Patient Ratings (Bar Graph)',
            font: { size: 18 }
          }
        },
        scales: {
          y: { beginAtZero: true, max: 5 }
        }
      }
    });
  </script>

</body>
</html>
