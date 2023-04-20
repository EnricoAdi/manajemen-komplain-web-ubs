<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold">Dashboard Admin</h1>
<div style="display:flex"> 
  <div class="dropdown mb-4 mr-2"> 
      <button class="btn btn-primary dropdown-toggle" type="button"
          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false" style=" padding-left: 30px; padding-right: 30px;padding-top:10px;padding-bottom:10px; background-color: <?=primary_color()?>;">
          Laporan
      </button>
      <div class="mt-2 dropdown-menu animated--fade-in"
          aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="<?=base_url()?>Admin/Laporan/JumlahKomplain">Laporan Jumlah Komplain</a>
          <a class="dropdown-item" href="<?=base_url()?>Admin/Laporan/DetailFeedback">Laporan Detail Feedback</a>
          <a class="dropdown-item" href="<?=base_url()?>Admin/Laporan/PerTopik">Laporan Per Topik</a>
      </div>
  </div>
  <?= primary_button("Master Topik", "", "", "mr-2 mb-2", "Admin/Master/Topik/Menu") ?>
  <?= primary_button("Master User", "", "", "mr-2 mb-2", "Admin/Master/User") ?>
  <?= primary_button("Master Email", "", "", "mr-2 mb-2 ", "Admin/Master/Email") ?>

</div>
<div class="row">

  <div class="col">

    <div class="card shadow mb-4 mt-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Komplain Masuk Tahun <?= $tahunIni; ?></h6>
      </div>
      <div class="card-body">
        <div class="chart-bar">
          <canvas id="chartKomplainMasuk"></canvas>
        </div>
        <hr>
        Grafik Jumlah Komplain Masuk Tahun <?= $tahunIni; ?>
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
        Grafik Divisi Terkomplain Bulan <?= $bulanIni; ?>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="url" value="<?= base_url() ?>">
<input type="hidden" id="bulanDalamAngka" value="<?= $bulanDalamAngka ?>">
<input type="hidden" id="tahunDalamAngka" value="<?= $tahunDalamAngka ?>">
<div class="row mb-4">
  <div class="col">
    <?= card_type_1("Total Komplain Bulan $bulanIni", $totalKomplainBulanIni, "fa-book", "primary") ?>

  </div>
  <div class="col">
    <?= card_type_1("Divisi Terkomplain Terbanyak", $divisiTerbanyak, "fa-user", "primary") ?>
  </div>
</div>

<script>
  window.onload = () => {

    const chartDivisi = document.getElementById("chartDivisi");
    const baseUrl = document.getElementById("url").value;
    const bulanDalamAngka = document.getElementById("bulanDalamAngka").value;
    const tahunDalamAngka = document.getElementById("tahunDalamAngka").value;

    let urlDoughnut = `${baseUrl}Admin/Dashboard/jumlahKomplainDivisiByMonth/${bulanDalamAngka}/${tahunDalamAngka}`;
    fetch(urlDoughnut).then(res => res.json())
      .then(res => {
        let labels = [];
        let data = [];
        let backgroundColor = ['#4e73df', '#1cc88a', '#36b9cc', '#a629cc', '#baa1a4', '#a229a7']
        res.forEach(d => {
          labels.push(d.NAMA)
          data.push(d.TOTAL)
        });

        var donutChartDivisi = new Chart(chartDivisi, {
          type: 'doughnut',
          data: {
            labels: labels,
            datasets: [{
              data: data,
              backgroundColor: backgroundColor,
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
              display: true
            },
            cutoutPercentage: 80,
          },
        });
      })
    
     
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

    // Bar Chart   
    let urlBar= `${baseUrl}Admin/Dashboard/jumlahKomplainMasukByYear/${tahunDalamAngka}`;
    const chartKomplainMasuk = document.getElementById("chartKomplainMasuk"); 
    fetch(urlBar).then(res => res.json())
    .then(res=> { 
      let labels = [];
      let data = [];
      let maks = 20;
      res.forEach(d => {
        labels.push(d.BULAN)
        data.push(parseInt(d.TOTAL))
        if(d.TOTAL > maks){
          maks = parseInt(d.TOTAL);
        }
      }); 
      var myBarChartKomplainMasuk = new Chart(chartKomplainMasuk, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: "Jumlah Komplain",
            backgroundColor: "<?= primary_color(); ?>",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: data,
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
                maxTicksLimit: 10 //ini untuk jumlah bar yang ditampilin
              },
              maxBarThickness: 25,
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maks, //ini untuk jumlah maksimal bar
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
    });
  }
</script>