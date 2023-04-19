<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Dashboard Admin</h1>

<?= primary_button("Laporan", "", "", "mr-2 mb-2", "Admin/Laporan/DetailFeedback") ?>
<?= primary_button("Master Topik", "", "", "mr-2 mb-2", "Admin/Master/Topik") ?>
<?= primary_button("Master User", "", "", "mr-2 mb-2", "Admin/Master/User") ?>
<?= primary_button("Master Email", "", "", "mr-2 mb-2 ", "Admin/Master/Email") ?>

<div class="row">

  <div class="col">

    <div class="card shadow mb-4 mt-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Komplain Masuk Tahun <?=$tahunIni;?></h6>
      </div>
      <div class="card-body">
        <div class="chart-bar">
          <canvas id="chartKomplainMasuk"></canvas>
        </div>
        <hr>
        Grafik Jumlah Komplain Masuk Tahun <?=$tahunIni;?>
      </div>
    </div>

  </div>

  <div class="col">
    <div class="card shadow mb-4 mt-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Divisi Terkomplain</h6>
      </div>
      <div class="card-body">
        <div class="chart-bar">
          <canvas id="chartDivisi"></canvas>
        </div>
        <hr>
        Grafik Divisi Terkomplain Bulan <?=$bulanIni;?>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col">
    <?= card_type_1("Total Komplain Bulan $bulanIni", $totalKomplainBulanIni, "fa-book","primary") ?>

  </div>
  <div class="col">
    <?= card_type_1("Divisi Terkomplain Terbanyak", $divisiTerbanyak, "fa-user","primary") ?>
</div>
</div>

<script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  // Bar Chart Example
  var chartKomplainMasuk = document.getElementById("chartKomplainMasuk");
  var myBarChartKomplainMasuk = new Chart(chartKomplainMasuk, {
    type: 'bar',
    data: {
      labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
      datasets: [{
        label: "Jumlah Komplain",
        backgroundColor: "<?= primary_color(); ?>",
        hoverBackgroundColor: "#2e59d9",
        borderColor: "#4e73df",
        data: [4215, 5312, 6251, 7841, 9821, 14984, 2000, 2331, 1233, 1234, 1234, 1234],
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 12 //ini untuk jumlah bar yang ditampilin
          },
          maxBarThickness: 25,
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: 15000, //ini untuk jumlah maksimal bar
            maxTicksLimit: 7,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
              return '' + number_format(value);
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
          }
        }
      },
    }
  });
  // Bar Chart Example
  var chartDivisi = document.getElementById("chartDivisi");
  var donutChartDivisi = new Chart(chartDivisi, {
    type: 'doughnut',
    data: {
      labels: ["Variasi", "IT", "Kalung", "Hollow"],
      datasets: [{
        data: [55, 30, 15, 40],
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#a629cc'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },

    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
</script>