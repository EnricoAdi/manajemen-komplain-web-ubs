<style>
    @media print{
       
        #areaprint{
            visibility: visible;
            background-color: white;
        }
        #accordionSidebar, #titlePage, #formPrompt{
            display: none;
            background-color: white;
            
        }
    }
</style>
<h1 class="h3 mb-4 text-gray-800" style="font-weight:bold" id="titlePage">Laporan Jumlah Komplain</h1>

<form action="<?= base_url() ?>Admin/Laporan/JumlahKomplain" method="get" class="mt-4 mb-4"  id="formPrompt">
    <div class="row">
        <div class="col">
            <label for="topik" class="form-label">Departemen</label>
            <select name="divisi" class="form-control">
                <?php
                foreach ($departemens as $departemen) {
                    if($departemen->KODE_DIVISI == $selectedDepartemen->KODE_DIVISI){    
                        echo "<option value='$departemen->KODE_DIVISI' selected>$departemen->NAMA_DIVISI</option>";
                    }else{
                        echo "<option value='$departemen->KODE_DIVISI'>$departemen->NAMA_DIVISI</option>";

                    }
                }
                ?>
            </select>
            <label for="" class="form-label mt-4">Tahun Periode</label>
            <input type="number" class="form-control" name="tahun" max="<?= $yearnow ?>" min="1950" value="<?= $yearnow ?>" required>
        </div>
        <div class="col">


            <label for="topik" class="form-label"></label>
            <button class="btn btn-primary" style="margin-top: 102px; width: 100%;background-color: <?= primary_color(); ?>;">

                <i class="fas fa-fw fa-file mr-2"></i>
                Buat Laporan</button>
        </div>
        <div class="col">
            <label for="topik" class="form-label"></label>
            <div class="btn btn-primary" style="margin-top: 102px; width:100%;background-color: <?= primary_color(); ?>;" onclick="cetak()">

                <i class="fas fa-fw fa-print mr-2" style="font-weight: bolder;"></i>
                Cetak Laporan</div>
        </div>
    </div>
    <div class="mt-4">Hasil Laporan :</div>
</form> 

<div class=" mb-4 mt-4" style="background-color: white;" id="areaprint">
    <div class="card-header py-3 d-flex" style="background-color: white;">
            <img src="<?= asset_url(); ?>images/logo.png" style="width:206px; height:92px; margin-top: 12px;">
            <div class="ml-4">
                <h4 class="font-weight-bold">Laporan Jumlah Komplain</h4>
                <p>Manajemen Komplain</p>
                <p>Departemen : <?=$selectedDepartemen->NAMA_DIVISI?></p>
                <p>Tahun : <?= $yearnow; ?></p>
            </div>
     </div>
    <div class="row"> 
        <div class="col">

            <div class="card mb-4 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Grafik Jumlah Komplain Masuk Tahun <?= $yearnow; ?></h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="chartKomplainMasuk"></canvas>
                    </div>
                    <hr>
                    Komplain Masuk Tahun <?= $yearnow; ?>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="card mb-4 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="areaChartPenanganan"></canvas>
                    </div>
                    <hr>
                    Kecepatan Penanganan Komplain
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            
        <div class="card mb-4 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Grafik Skor Pencapaian Komplain Tahun <?= $yearnow; ?></h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="chartSkorPencapaian"></canvas>
                    </div>
                    <hr>
                    Chart Skor Pencapaian Tahun <?= $yearnow; ?>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-4 mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rangkuman Laporan Komplain Departemen NamaDepartemen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Komplain Diterima</th> 
                            <th>Jumlah Terlambat Penanganan</th> 
                            <th>Skor Pencapaian Komplain</th> 
                            <th>Kecepatan Penanganan (%)</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = () => {
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
        var ctx = document.getElementById("areaChartPenanganan");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
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
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '$' + number_format(value);
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
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    }
    
    function cetak(){ 
        window.print()
    } 
</script>