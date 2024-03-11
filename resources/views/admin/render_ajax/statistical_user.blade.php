<div>
    <canvas id="myChart4"></canvas>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      const ctx4 = document.getElementById('myChart4');
      new Chart(ctx4, {
          type: 'line',
          data: {
            labels: @json($labels_user_line),
            datasets: [{
              label: @json($label_user_line),
              data: @json($data_user_line),
              fill: false,
              borderColor: 'rgb(75, 192, 192)',
              tension: 0.1
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