<div>
    <canvas id="myChart"></canvas>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      const ctx = document.getElementById('myChart');
      new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json($labels_article), // Chuyển mảng labels thành JSON
              datasets: [{
                  label: @json($label_article),
                  data: @json($data_article), // Chuyển mảng data thành JSON
                  borderWidth: 1,
                  backgroundColor: [
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                  ],
                  borderColor: [
                    'rgb(201, 203, 207)',
                    'rgb(153, 102, 255)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 159, 64)',
                    'rgb(75, 192, 192)',
                  ],
              }],
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