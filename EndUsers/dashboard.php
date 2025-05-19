<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<h2 class="mb-4">Dashboard</h2>
<?php
if($role == "Admin"){
?>
<div class="row">
  <div class="col-lg-4 md-3 mb-4">
    <div class="card bg-danger fs-4 text-white ">
      <div class="card-body">
        <h5 class="card-title"> <i class="fas fa-users "></i> No.<span> | Users</span></h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="ps-3">
          <?php 
            $dash_user = "SELECT * FROM `users` WHERE `access` = 'DepHead'";
            $dash_users = mysqli_query($con, $dash_user);

            if($user_total = mysqli_num_rows($dash_users)){
              echo '<h4 class="mb-0 mx-2">'.$user_total.'</h4>';
            }
            else{
              echo '<h4 class="mb-0">EMPTY</h4>';
            }
          ?>
            <!-- <span class="text-success small pt-1 fw-bold">Data Fetching</span> <span class="text-muted small pt-2 ps-1"></span> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 md-3  mb-4">
    <div class="card bg-success fs-4 text-white ">
      <div class="card-body">
        <h5 class="card-title"> <i class="fas fa-box"></i> No.<span> | Orders</span></h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="ps-3">
          <?php 
            $dash_user = "SELECT * FROM `orders`";
            $dash_users = mysqli_query($con, $dash_user);

            if($user_total = mysqli_num_rows($dash_users)){
              echo '<h4 class="mb-0 mx-3">'.$user_total.'</h4>';
            }
            else{
              echo '<h4 class="mb-0">EMPTY</h4>';
            }
          ?>
            <!-- <span class="text-success small pt-1 fw-bold">Data Fetching</span> <span class="text-muted small pt-2 ps-1"></span> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 md-3  mb-4">
    <div class="card bg-warning fs-4 text-white ">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-box"></i> No.<span> | Request</span></h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="ps-3">
          <?php 
            $dash_user = "SELECT * FROM `request` WHERE `statusOne` = 0";
            $dash_users = mysqli_query($con, $dash_user);

            if($user_total = mysqli_num_rows($dash_users)){
              echo '<h4 class="mb-0 mx-3">'.$user_total.'</h4>';
            }
            else{
              echo '<h4 class="mb-0">EMPTY</h6>';
            }
          ?>
            <!-- <span class="text-success small pt-1 fw-bold">Data Fetching</span> <span class="text-muted small pt-2 ps-1"></span> -->
          </div>
        </div>
      </div>
    </div>
  </div>

    <?php
        $datePosted = [];
        $orders = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $orders_query = "SELECT COUNT(*) AS total_orders FROM `orders` WHERE DATE(datePosted) = '$date'";
            $orders_result = mysqli_query($con, $orders_query);
            $orders_data = mysqli_fetch_assoc($orders_result);
            $orders_count = $orders_data['total_orders'] ?? 0;
            $orders[] = $orders_count;
            $dates[] = date('Y-m-d\TH:i:s.000\Z', strtotime($date));
        }
        ?>

  <div class="col-lg-12 md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Purchased Orders <span>/Reports</span></h5>
              <div id="reportsChart"></div>
        </div>
    </div>
  </div>

  <div class="col-lg-12 md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Monthly<span>/Request</span></h5>
              <?php
                $select = "SELECT DATE_FORMAT(dateNeeded, '%Y-%m') AS requestMonth, 
                                  COUNT(*) AS totalRequests 
                          FROM `request` 
                          GROUP BY requestMonth 
                          ORDER BY requestMonth ASC"; 

                $query = mysqli_query($con, $select);

                $xValues = array(); 
                $yValues = array();

                while ($row = mysqli_fetch_assoc($query)) {
                    $requestMonth = $row['requestMonth'];
                    $totalRequests = $row['totalRequests'];
                    $xValues[] = $requestMonth;
                    $yValues[] = $totalRequests;
                }
              ?>
              <canvas class="bg-white" id="myChart" ></canvas>
        </div>
    </div>
  </div>
</div>
<?php
}else{
?>
<div class="row">
  <div class="col-lg-6 md-3  mb-4">
    <div class="card bg-info fs-4 text-white ">
      <div class="card-body">
        <h5 class="card-title"> <i class="fas fa-box"></i> No.<span> | Pick-up Orders</span></h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="ps-3">
          <?php 
            $dash_user = "SELECT * FROM `orderconfirmation` WHERE `empID` = '$username'";
            $dash_users = mysqli_query($con, $dash_user);

            if($user_total = mysqli_num_rows($dash_users)){
              echo '<h4 class="mb-0 mx-3">'.$user_total.'</h4>';
            }
            else{
              echo '<h4 class="mb-0">EMPTY</h4>';
            }
          ?>
            <!-- <span class="text-success small pt-1 fw-bold">Data Fetching</span> <span class="text-muted small pt-2 ps-1"></span> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 md-3  mb-4">
    <div class="card bg-primary fs-4 text-white ">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-box"></i> No.<span> |Users Request</span></h5>
        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="ps-3">
          <?php 
            $dash_user = "SELECT * FROM `request` WHERE `empID` = '$username' ";
            $dash_users = mysqli_query($con, $dash_user);

            if($user_total = mysqli_num_rows($dash_users)){
              echo '<h4 class="mb-0 mx-3">'.$user_total.'</h4>';
            }
            else{
              echo '<h4 class="mb-0">EMPTY</h6>';
            }
          ?>
            <!-- <span class="text-success small pt-1 fw-bold">Data Fetching</span> <span class="text-muted small pt-2 ps-1"></span> -->
          </div>
        </div>
      </div>
    </div>
  </div>

    <?php
        $datePosted = [];
        $orders = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $orders_query = "SELECT COUNT(*) AS total_orders FROM `orderconfirmation` WHERE DATE(datePosted) = '$date' AND `status` = 1 AND `empID` = '$username'";
            $orders_result = mysqli_query($con, $orders_query);
            $orders_data = mysqli_fetch_assoc($orders_result);
            $orders_count = $orders_data['total_orders'] ?? 0;
            $orders[] = $orders_count;
            $dates[] = date('Y-m-d\TH:i:s.000\Z', strtotime($date));
        }
        ?>

  <div class="col-lg-12 md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Users Approved Order<span> | Reports</span></h5>
              <div id="reportsChart"></div>
        </div>
    </div>
  </div>

  <div class="col-lg-12 md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Users Monthly<span> | Request</span></h5>
              <?php
                $select = "SELECT DATE_FORMAT(dateNeeded, '%Y-%m') AS requestMonth, 
                                  COUNT(*) AS totalRequests 
                          FROM `request` e
                          WHERE `empID` = '$username'
                          GROUP BY requestMonth 
                          ORDER BY requestMonth ASC"; 

                $query = mysqli_query($con, $select);

                $xValues = array(); 
                $yValues = array();

                while ($row = mysqli_fetch_assoc($query)) {
                    $requestMonth = $row['requestMonth'];
                    $totalRequests = $row['totalRequests'];
                    $xValues[] = $requestMonth;
                    $yValues[] = $totalRequests;
                }
              ?>
              <canvas class="bg-white" id="myChart" ></canvas>
        </div>
    </div>
  </div>
</div>
<?php }?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const xValues = <?php echo json_encode($xValues); ?>;
  const yValues = <?php echo json_encode($yValues); ?>;
  const barColors = ["#4DA1A9", "#52A7EA", "#5E9761", "#D8CD72", "#D6913B", "#929FA5"];

  new Chart("myChart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: "Monthly Expenses"
      }
    }
  });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dates = <?php echo json_encode($dates); ?>;
        const orders = <?php echo json_encode($orders); ?>;
        

        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [ {
                name: 'Orders',
                data: orders,
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#088395' , '#E57068', '#2eca6a', '#ff771d'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'datetime',
                categories: dates,
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }).render();
    });
</script>

<?php include_once("./components/footscript.php"); ?>