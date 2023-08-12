<?php 
include('config.php');
$sdate = strtotime($_POST['date'].' 00:00:00');

$edate = strtotime($_POST['tdate'].' 23:59:59');

$get_today_deposit = mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from transactions where `created_at`>$sdate AND `created_at`<$edate AND ( remark like '%Points Added By Admin%' OR remark like 'Deposit%')"));
$tdoay_deposit = $get_today_deposit['total']+0;

$get_today_withdraw = mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from transactions where `created_at`>$sdate AND `created_at`<$edate AND ( remark like '%Deducted by admin%' OR remark like 'Withdraw%') AND remark != 'Withdraw cancelled by our team'"));
$tdoay_withdraw = $get_today_withdraw['total']+0;

$profit = $tdoay_deposit - $tdoay_withdraw;
?>

<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            
          <div class="col-lg-4 col-8">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                    <?php echo $tdoay_deposit; ?>
                </h3>

                <p>TODAY'S DEPOSIT</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-8">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                    <?php echo $tdoay_withdraw; ?>
                </h3>

                <p style="font-size:bold;">WITHDRAWAL</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-8">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                    <?php echo $profit; ?>
                    <sup style="font-size: 20px">₹</sup>
                </h3>

                <p>Total Profit</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
    
          </div>
          <!-- ./col -->
        </div>

</secion>


 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <!-- <button class="btn btn-primary">Bid History</button> -->
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User Name</th>
                      <th>User Mobile</th>
                      <th>Remark</th>
                      <th>Type</th>
                      <th>Amount</th>
                    
                    </tr>
                  </thead>
                  <tbody id="report">
                 <?php
               
                    $select = mysqli_query($con, "SELECT * FROM `transactions` WHERE `created_at`>$sdate AND `created_at`<$edate AND ( remark like '%Points Added By Admin%' OR remark like '%Points Withdraw By Admin%' OR remark like 'Deposit%' OR remark like 'Withdraw%') AND remark != 'Withdraw cancelled by our team'"); 
                
                    $i = 1;
                    while($row = mysqli_fetch_array($select)){
                        // user data
                        $userID = $row['user'];
                        $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$userID' ");
                        $fetch = mysqli_fetch_array($user);
                        
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php if($fetch['name'] != ''){ echo $fetch['name'];}else{ echo 'N/A'; } ?></td>
                        <td><?php if($fetch['mobile'] != ''){ echo $fetch['mobile'];}else{ echo 'N/A'; } ?></td>
                        <td><?php echo $row['remark'] ?></td>
                        <td><?php if($row['type'] != '1'){ echo 'Debit';}else{ echo 'Credit'; } ?></td>
                        
                        <td><?php if($row['amount'] != ''){echo $row['amount'];}else{ echo 'N/A'; } ?></td>
                    </tr>    
                    
                
                <?php
                $i++;
                    }
                ?>
                    
                  </tbody>
                </table>
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
    
