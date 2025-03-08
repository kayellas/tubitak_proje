<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tedarik Zincir Yönetimi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index.php" class="brand-link">
      <span class="brand-text font-weight-light">Tedarik Zincir Yönetimi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../../index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Grafikler
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="chart.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
            </ul>
          </li>
        
          <class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tablolar
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
              <li class="nav-item">
                <a href="../tables/data.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Lokasyon Bazlı Firma
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../map/map.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>MAP</p>

                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="../../urunekle.html" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Ürün Ekle
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
        </>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Grafikler</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../../index.php">Anasayfa</a></li>
              <li class="breadcrumb-item active">Grafikler</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Filtreleme seçenekleri -->
  <div>
    <label for="filterCategory">Kategoriye Göre Filtrele:</label>
    <select id="filterCategory" onchange="applyFilters()">
      <option value="all">Hepsi</option>
      <option value="1">Soft Drinks</option>
      <option value="2">Sıcak İçecekler</option>
      <option value="3">Alkollü İçecekler</option>

     
      <!-- Diğer kategori seçenekleri -->
    </select>
    <label for="filterDate">Yıla Göre Filtrele:</label>
    <select id="filterDate"  onchange="applyFilters()">
    <option value="all">Hepsi</option>
    <option value="2024">2024</option>
    <option value="2023">2023</option>
    <option value="2022">2022</option>
      <!-- Diğer tarih seçenekleri -->
    </select>
  </div>

 
 
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  
  const database = require('../db/database.js');

  
    // Filtreleme işlemini gerçekleştiren bir fonksiyon:
    function filterData() {
      var selectedDate = document.getElementById('filterDate').value;
  
      // Sunucudan veri çekme 
      fetch(`/api/data?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
          // Verileri kullanarak tüm grafikleri güncelleme
          updateAllCharts(data);
        })
        .catch(error => console.error('Veri çekme hatası:', error));
    }
  
    // Tüm grafikleri güncelleyen fonksiyon
    function updateAllCharts(data) {
      updateChart("areaChart", data.areaChartData, "Area Chart");
      updateChart("lineChart", data.lineChartData, "Line Chart");
      updateChart("donutChart", data.donutChartData, "Donut Chart");
    }

    function getData(selectedCategory, selectedDate, callback) {
      let query = 'SELECT * FROM urun WHERE 1';
    
      // Kategoriye göre filtreleme
      if (selectedCategory !== 'all') {
        query += ` AND kategori = '${selectedCategory}'`;
      }
    
      // Tarihe göre filtreleme
      if (selectedDate !== 'all') {
        // Örneğin: AND tarih = '2023-12-27'
      }
    
      // Sorguyu çalıştır
      connection.query(query, (error, results, fields) => {
        if (error) {
          console.error('Veri çekme hatası: ' + error.stack);
          callback(error, null);
          return;
        }
    
        // Veritabanından gelen verileri kullanarak istediğiniz işlemleri gerçekleştirin
        callback(null, results);
      });
    }
    
  
    // Tek bir grafik güncelleyen genel fonksiyon
    function updateChart(chartId, newData, chartTitle) {
      var chart = new Chart(document.getElementById(chartId).getContext('2d'), {
        type: 'line', // Grafik türünü istediğiniz gibi değiştirebilirsiniz
        data: {
          labels: newData.labels,
          datasets: [
            {
              label: chartTitle,
              data: newData.data,
              fill: false,
              borderColor: 'rgb(75, 192, 192)',
              tension: 0.1
            }
          ]
        },
        options: {
          scales: {
            x: {
              type: 'time',
              time: {
                unit: 'day'
              }
            },
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  
</script>







