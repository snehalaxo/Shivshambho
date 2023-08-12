<?php include('header.php');
$date2 = $_REQUEST['date'];

$date = date('d/m/Y',strtotime($_REQUEST['date']));


$digit = $_REQUEST['digit'];
$panna = $_REQUEST['panna'];
$session = $_REQUEST['session'];
$market = $_REQUEST['market'];


if($session == 'open'){
  $mrk = str_replace(' ','_',$market.' OPEN');
  
  $qry = "SELECT * FROM games WHERE bazar='$mrk' AND (number='$digit' OR number='$panna') AND date='$date'";
  
} else {

  
  $chk_if_query = mysqli_query($con, "select * from manual_market_results where market='$market' AND date='$date'");
  $chk_if_updated = mysqli_fetch_array($chk_if_query);

  $open = $chk_if_updated['open'];
  $opanna = $chk_if_updated['open_panna'];

  $mrk = str_replace(' ','_',$market.' CLOSE');
  $mrk2 = str_replace(' ','_',$market.'');
  
  $jodi = $open.$digit;
  
  $half1 = $opanna.'-'.$digit;
  $half2 = $panna.'-'.$open;
  
  $full = $opanna.'-'.$panna;
  
  $qry = "SELECT * FROM games WHERE (bazar='$mrk' OR bazar='$mrk2') AND (number='$digit' OR number='$panna' OR number='$jodi' OR number='$half1' OR number='$half2' OR number='$full') AND date='$date'";
  
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Winning History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Win History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    Details
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Bid Points</th>
                    <th>Winning Points</th>
                    <th>Market Name</th>
                    <th>Game Name</th>
                    <th>Bid number</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                        $winning = mysqli_query($con, $qry);
                        $i = 1;
                        while($row = mysqli_fetch_array($winning)){
                            $userID = $row['user'];
                            $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$userID' ");
                            $fetch = mysqli_fetch_array($user);
                                                    
                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $fetch['name']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['bazar']; ?></td>
                                <td><?php echo $row['game']; ?></td>
                                <td><?php echo $row['number']; ?></td>
                                <td><?php echo date('h:i A d-m-Y',$row['created_at']); ?></td>
                            </tr>
                    <?php
                            $i++;
                        }
                    ?>
                  </tbody>
                </table>
                
                <a href="declare-result.php?market=<?php echo "$market&date=$date2&session=$session&digit=$digit&panna=$panna&submit_manual=1"; ?>"><button class="btn btn-primary mt-4">Declare result</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php include('footer.php'); ?>