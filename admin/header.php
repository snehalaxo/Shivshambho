<?php
session_start();
	$main_admin_mail = "admin@gmail.com";
	$main_partner_mail = "admin@milansatta.in";
  include('config.php');
  if(!isset($_SESSION['userID'])){
    echo "<script>window.location= 'index.php';</script>";
  }
  
  $stamp = time();
  
  
  
function getPatti(){
    
        $numbers[] ="100";
        $numbers[] ="119";
        $numbers[] ="155";
        $numbers[] ="227";
        $numbers[] ="335";
        $numbers[] ="344";
        $numbers[] ="399";
        $numbers[] ="588";
        $numbers[] ="669";
        $numbers[] ="200";
        $numbers[] ="110";
        $numbers[] ="228";
        $numbers[] ="255";
        $numbers[] ="336";
        $numbers[] ="499";
        $numbers[] ="660";
        $numbers[] ="688";
        $numbers[] ="778";
        $numbers[] ="300";
        $numbers[] ="166";
        $numbers[] ="229";
        $numbers[] ="337";
        $numbers[] ="355";
        $numbers[] ="445";
        $numbers[] ="599";
        $numbers[] ="779";
        $numbers[] ="788";
        $numbers[] ="400";
        $numbers[] ="112";
        $numbers[] ="220";
        $numbers[] ="266";
        $numbers[] ="338";
        $numbers[] ="446";
        $numbers[] ="455";
        $numbers[] ="699";
        $numbers[] ="770";
        $numbers[] ="500";
        $numbers[] ="113";
        $numbers[] ="122";
        $numbers[] ="177";
        $numbers[] ="339";
        $numbers[] ="366";
        $numbers[] ="447";
        $numbers[] ="799";
        $numbers[] ="889";
        $numbers[] ="600";
        $numbers[] ="114";
        $numbers[] ="277";
        $numbers[] ="330";
        $numbers[] ="448";
        $numbers[] ="466";
        $numbers[] ="556";
        $numbers[] ="880";
        $numbers[] ="899";
        $numbers[] ="700";
        $numbers[] ="115";
        $numbers[] ="133";
        $numbers[] ="188";
        $numbers[] ="223";
        $numbers[] ="377";
        $numbers[] ="449";
        $numbers[] ="557";
        $numbers[] ="566";
        $numbers[] ="800";
        $numbers[] ="116";
        $numbers[] ="224";
        $numbers[] ="233";
        $numbers[] ="288";
        $numbers[] ="440";
        $numbers[] ="477";
        $numbers[] ="558";
        $numbers[] ="990";
        $numbers[] ="900";
        $numbers[] ="117";
        $numbers[] ="144";
        $numbers[] ="199";
        $numbers[] ="225";
        $numbers[] ="388";
        $numbers[] ="559";
        $numbers[] ="577";
        $numbers[] ="667";
        $numbers[] ="550";
        $numbers[] ="668";
        $numbers[] ="244";
        $numbers[] ="299";
        $numbers[] ="226";
        $numbers[] ="488";
        $numbers[] ="677";
        $numbers[] ="118";
        $numbers[] ="334";
        $numbers[] ="128";
        $numbers[] ="137";
        $numbers[] ="146";
        $numbers[] ="236";
        $numbers[] ="245";
        $numbers[] ="290";
        $numbers[] ="380";
        $numbers[] ="470";
        $numbers[] ="489";
        $numbers[] ="560";
        $numbers[] ="678";
        $numbers[] ="579";
        $numbers[] ="129";
        $numbers[] ="138";
        $numbers[] ="147";
        $numbers[] ="156";
        $numbers[] ="237";
        $numbers[] ="246";
        $numbers[] ="345";
        $numbers[] ="390";
        $numbers[] ="480";
        $numbers[] ="570";
        $numbers[] ="679";
        $numbers[] ="120";
        $numbers[] ="139";
        $numbers[] ="148";
        $numbers[] ="157";
        $numbers[] ="238";
        $numbers[] ="247";
        $numbers[] ="256";
        $numbers[] ="346";
        $numbers[] ="490";
        $numbers[] ="580";
        $numbers[] ="670";
        $numbers[] ="689";
        $numbers[] ="130";
        $numbers[] ="149";
        $numbers[] ="158";
        $numbers[] ="167";
        $numbers[] ="239";
        $numbers[] ="248";
        $numbers[] ="257";
        $numbers[] ="347";
        $numbers[] ="356";
        $numbers[] ="590";
        $numbers[] ="680";
        $numbers[] ="789";
        $numbers[] ="140";
        $numbers[] ="159";
        $numbers[] ="168";
        $numbers[] ="230";
        $numbers[] ="249";
        $numbers[] ="258";
        $numbers[] ="267";
        $numbers[] ="348";
        $numbers[] ="357";
        $numbers[] ="456";
        $numbers[] ="690";
        $numbers[] ="780";
        $numbers[] ="123";
        $numbers[] ="150";
        $numbers[] ="169";
        $numbers[] ="178";
        $numbers[] ="240";
        $numbers[] ="259";
        $numbers[] ="268";
        $numbers[] ="349";
        $numbers[] ="358";
        $numbers[] ="457";
        $numbers[] ="367";
        $numbers[] ="790";
        $numbers[] ="124";
        $numbers[] ="160";
        $numbers[] ="179";
        $numbers[] ="250";
        $numbers[] ="269";
        $numbers[] ="278";
        $numbers[] ="340";
        $numbers[] ="359";
        $numbers[] ="368";
        $numbers[] ="458";
        $numbers[] ="467";
        $numbers[] ="890";
        $numbers[] ="125";
        $numbers[] ="134";
        $numbers[] ="170";
        $numbers[] ="189";
        $numbers[] ="260";
        $numbers[] ="279";
        $numbers[] ="350";
        $numbers[] ="369";
        $numbers[] ="378";
        $numbers[] ="459";
        $numbers[] ="567";
        $numbers[] ="468";
        $numbers[] ="126";
        $numbers[] ="135";
        $numbers[] ="180";
        $numbers[] ="234";
        $numbers[] ="270";
        $numbers[] ="289";
        $numbers[] ="360";
        $numbers[] ="379";
        $numbers[] ="450";
        $numbers[] ="469";
        $numbers[] ="478";
        $numbers[] ="568";
        $numbers[] ="127";
        $numbers[] ="136";
        $numbers[] ="145";
        $numbers[] ="190";
        $numbers[] ="235";
        $numbers[] ="280";
        $numbers[] ="370";
        $numbers[] ="479";
        $numbers[] ="460";
        $numbers[] ="569";
        $numbers[] ="389";
        $numbers[] ="578";
        $numbers[] ="589";
        $numbers[] ="000";
        $numbers[] ="111";
        $numbers[] ="222";
        $numbers[] ="333";
        $numbers[] ="444";
        $numbers[] ="555";
        $numbers[] ="666";
        $numbers[] ="777";
        $numbers[] ="888";
        $numbers[] ="999";
        
        return $numbers;
}

function getOpenCloseTiming($xc){
    
    if($xc['days'] == "ALL" || substr_count($xc['days'],$day) == 0){
        if(strtotime($time)<strtotime($xc['open']))
        {
            $xc['is_open'] = "1";
        }
        else
        {
            $xc['is_open'] = "0";
        }
        
        if(strtotime($time)<strtotime($xc['close']))
        {
            $xc['is_close'] = "1";
        }
        else
        {
            $xc['is_close'] = "0";
        }
    } else if(substr_count($xc['days'],$day."(CLOSE)") > 0){
        $xc['is_open'] = "0";
        $xc['is_close'] = "0";
        $xc['open'] = "CLOSE";
        $xc['close'] = "CLOSE";
    } else {
        $time_array = explode(",",$xc['days']);
        for($i =0;$i< count($time_array);$i++){
            if(substr_count($time_array[$i],$day) > 0){
                $day_conf = $time_array[$i];
            }
        }
        
        $day_conf = str_replace($day."(","",$day_conf);
        $day_conf = str_replace(")","",$day_conf);
        
        $mrk_time = explode("-",$day_conf);
        
        
        $xc['open'] = $mrk_time[0];
        $xc['close'] = $mrk_time[1];
        
        if(strtotime($time)<strtotime($mrk_time[0]))
        {
            $xc['is_open'] = "1";
        }
        else
        {
            $xc['is_open'] = "0";
        }
        
        if(strtotime($time)<strtotime($mrk_time[1]))
        {
            $xc['is_close'] = "1";
        }
        else
        {
            $xc['is_close'] = "0";
        }
    }

    return $xc;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="logout.php" role="button">
          <i class="fas fa-power-off"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/logo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div> -->

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
          <li class="nav-item menu-open">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User Management
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="users_old.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User Management (With sort)
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="winning-prediction.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winner prediction
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          
           <li class="nav-item">
            <a href="transaction.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Profit/Loss
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
         
           
          <li class="nav-item">
            <a href="declare-result.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Declare Result
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="winning-details.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winning Details
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="image-slider-app.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Image Slider
              </p>
            </a>
          </li>
            <!--<?php if($_SESSION['userID'] == $main_admin_mail){ ?>-->
            <!--  <li class="nav-item">-->
            <!--    <a href="partner-transactions.php" class="nav-link">-->
            <!--      <i class="far fa-circle nav-icon"></i>-->
            <!--      <p>Partner Wallet</p>-->
            <!--    </a>-->
            <!--  </li>-->
            <!--  <?php } ?>-->
           <li class="nav-item">
            <a href="bet-list.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Bet Filter
              </p>
            </a>
          </li>
          
            <li class="nav-item">
                <a href="sell-report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Sell Report</p>
                </a>
              </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Report Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="bid-history.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bid History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="withdraw-report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Withdraw Report</p>
                </a>
              </li>
            
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Wallet Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                 <li class="nav-item">
                <a href="upi_verification.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>UPI Verification</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="auto-add-points.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Auto Add Points</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="withdraw-points-request.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Withdraw Points Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add-points-user-wallet.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Points (User Wallet)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="bid-revert.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bid Revert</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="change-password.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
              
              <?php if($_SESSION['userID'] == $main_admin_mail){ ?>
              <li class="nav-item">
                <a href="main-settings.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Main Settings</p>
                </a>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a href="contact-us.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contact Us Details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="how-to-play.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>How To Play</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Game Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="game-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Game List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="game-rates.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Game Rates</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Notice Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="notice.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notice Management</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="send-notification.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send Notification</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Games & Numbers
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="single-digit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Single Digit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="jodi-digit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jodi Digit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="single-pana.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Single Pana</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="double-pana.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Double Pana</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="triple-pana.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Triple Pana</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="half-sangam.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Half Sangam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="full-sangam.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Full Sangam</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">Personal Games</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Starline
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="starline-market-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Game List</p>
                </a>
              </li>
              <!--<li class="nav-item">-->
              <!--  <a href="starline-game-rates.php" class="nav-link">-->
              <!--    <i class="far fa-circle nav-icon"></i>-->
              <!--    <p>Game Rates</p>-->
              <!--  </a>-->
              <!--</li>-->
              <li class="nav-item">
                <a href="starline-bid-history.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bid History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="starline-declare-result.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Declare Result</p>
                </a>
              </li>
             <li class="nav-item">
                <a href="sell-report-starline.php" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Sell Report
                    <span class="right badge badge-danger">New</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="starline-winning-report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Winning Report</p>
                </a>
              </li>
            </ul>
          </li>
          
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Delhi Jodi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="delhi-market-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Game List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="starline-game-rates.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Game Rates</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="bid-history-delhi.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bid History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="declare-result-delhi.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Declare Result</p>
                </a>
              </li>
             <li class="nav-item">
                <a href="sell-report-delhi.php" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Sell Report
                    <span class="right badge badge-danger">New</span>
                  </p>
                </a>
              </li>
            
            </ul>
          </li>
          
            
            
            </ul>
          </li>
          
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">