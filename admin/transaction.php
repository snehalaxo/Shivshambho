<?php include('header.php'); ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Deposit/Withdraw Transactions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Deposit/Withdraw Transactions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Filters</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" id="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                            </div>
                        </div>
                       <div class="col-md-4">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" id="tdate" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                            </div>
                        </div>
                       
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <button id="go" class="btn btn-primary mt-4">SAVE</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.card -->

        </div>
    </section>
    
    <div  id="report">
    <!-- Main content -->
    <?php 
$sdate = strtotime(date('m/d/Y').' 00:00:00');

$edate = strtotime(date('m/d/Y').' 23:59:59');
$get_today_deposit = mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from transactions where `created_at`>$sdate AND `created_at`<$edate AND ( remark like '%Points Added By Admin%' OR remark like '%Deposit%') AND remark != 'Withdraw cancelled by our team'"));
$tdoay_deposit = $get_today_deposit['total']+0;

$get_today_withdraw = mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from transactions where `created_at`>$sdate AND `created_at`<$edate AND ( remark like '%Deducted by admin%' OR remark like '%Withdraw%') AND remark != 'Withdraw cancelled by our team'"));
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
                      <th>Type</th>
                      <th>Amount</th>
                    
                    </tr>
                  </thead>
                  <tbody id="report">
                 <?php
               
                    $select = mysqli_query($con, "SELECT * FROM `transactions` WHERE `created_at`>$sdate AND `created_at`<$edate AND ( remark like '%Points Added By Admin%' OR remark like '%Points Withdraw By Admin%' OR remark like '%Deposit%' OR remark like '%Withdraw%') AND remark != 'Withdraw cancelled by our team'"); 
                
                    $i = 1;
                    while($row = mysqli_fetch_array($select)){
                        // user data
                        $userID = $row['user'];
                        $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$userID'");
                        $fetch = mysqli_fetch_array($user);
                        
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php if($fetch['name'] != ''){ echo $fetch['name'];}else{ echo 'N/A'; } ?></td>
                        <td><?php if($fetch['mobile'] != ''){ echo $fetch['mobile'];}else{ echo 'N/A'; } ?></td>
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
    

    <!-- /.content -->
</div>
<?php include('footer.php'); ?>

<script>
// fetch sell report
$('#go').click(function(){
    var date = $('#date').val();
    var tdate = $('#tdate').val();
    
    if(date != ''){
        $.ajax({    //create an ajax request to 
            type: "POST",
            url: "transaction-ajax.php",             
            data:{date:date,tdate:tdate},  //expect html to be returned                
            success: function(data){
                //$('#tbody').html(data);
                $('#report').html(data);
            }
        });
    }
});

    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>