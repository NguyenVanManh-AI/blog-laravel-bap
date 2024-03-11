@extends('admin.layouts.view_content')
@section('content-blog')
<link rel="stylesheet" href="{{ asset('admin/css/statistical.css') }}">
<div class="col-12 mx-auto" id="index_statistical">
  <div class="row m-0 mb-4" id="overview_data">
    <p id="title_statistical" class="mx-auto col-12 text-center"><span><i class="fa-solid fa-chart-line"></i></span>  System overview data</p>
    <div id="big_statistical" class="m-0 mt-2">
        <div class="statistical" id="user">
          <p class="p-0">
            <span class="icon_statis"><i class="fa-solid fa-user-check"></i></span> 
            <span class="text_statis">Total number of users in the system</span> 
          </p> 
          <p class="number_statis p-0">{{$number_user}}</p>
        </div>
        <div class="statistical" id="admin">
          <p class="p-0">
            <span class="icon_statis"><i class="fa-solid fa-user-shield"></i></span> 
            <span class="text_statis">Total number of admins in the system</span> 
          </p> 
          <p class="number_statis p-0">{{$number_admin}}</p>
        </div>
        <div class="statistical" id="article">
          <p class="p-0">
            <span class="icon_statis"><i class="fa-solid fa-newspaper"></i></span> 
            <span class="text_statis">Total number of articles in the system</span> 
          </p> 
          <p class="number_statis p-0">{{$number_article}}</p>
        </div>
        <div class="statistical" id="comment">
          <p class="p-0">
            <span class="icon_statis"><i class="fa-solid fa-message"></i></span> 
            <span class="text_statis">Total number of comments in the system</span> 
          </p> 
          <p class="number_statis p-0">{{$number_comment}}</p>
        </div>
        <div class="statistical" id="message">
          <p class="p-0">
            <span class="icon_statis"><i class="fa-brands fa-facebook-messenger"></i></span> 
            <span class="text_statis">Total number of messages in the system</span> 
          </p> 
          <p class="number_statis p-0">{{$number_message}}</p>
        </div>
        <div class="statistical" id="notify">
          <p class="p-0">
            <span class="icon_statis"><i class="fa-solid fa-bell"></i></span> 
            <span class="text_statis">Total number of notifies in the system</span> 
          </p> 
          <p class="number_statis p-0">{{$number_notify}}</p>
        </div>
    </div>
  </div>
  <hr class="col-8 mx-auto">
  <div class="row">
    <div class="col-6">
      <p class="col-8 mx-auto">Statistics on article growth over time</p>
      <select id="select_article" class="form-control form-control-sm col-6 mx-auto">
        <option value="year">Year</option>
        <option value="month">Month</option>
        <option value="week">Week</option>
      </select>
      <div id="chart_bar_article">
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
      </div>
    </div>
    <div class="col-6">
      <p class="col-8 mx-auto">Statistics on comment growth over time</p>
      <select id="select_comment" class="form-control form-control-sm col-6 mx-auto">
        <option value="year">Year</option>
        <option value="month">Month</option>
        <option value="week">Week</option>
      </select>
      <div id="chart_bar_comment">
        <div>
          <canvas id="myChart2"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx2 = document.getElementById('myChart2');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: @json($labels_comment), // Chuyển mảng labels thành JSON
                    datasets: [{
                        label: @json($label_comment),
                        data: @json($data_comment), // Chuyển mảng data thành JSON
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
      </div>
    </div>
  </div>
  <hr class="col-8 mx-auto">
  <div class="row mt-4">
    <div class="col-6">
      <p class="col-8 mx-auto">Statistics of blocked and accepted people</p>
      <div id="chart_bar_user">
        <div>
          <canvas id="myChart3"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx3 = document.getElementById('myChart3');
            new Chart(ctx3, {
                type: 'polarArea',
                data: {
                  labels: @json($labels_user),
                  datasets: [{
                    label: 'My First Dataset',
                    data: @json($data_user),
                    backgroundColor: [
                      'rgb(255, 99, 132)',
                      'rgb(75, 192, 192)',
                      'rgb(255, 205, 86)',
                      'rgb(201, 203, 207)',
                      'rgb(54, 162, 235)'
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
      </div>
    </div>
    <div class="col-6">
      <p class="col-8 mx-auto">Statistics on user growth over time</p>
      <select id="select_user" class="form-control form-control-sm col-6 mx-auto">
        <option value="year">Year</option>
        <option value="month">Month</option>
        <option value="week">Week</option>
      </select>
      <div id="chart_bar_user_line">
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
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('admin/js/statistical.js') }}"></script>
@endsection