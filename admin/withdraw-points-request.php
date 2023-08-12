<?php 

include('header.php');



$num_results_on_page = 10;  
if (isset($_GET["page"])) {
	$page  = $_GET["page"]; 
	} 
	else{ 
	$page=1;
	};  
$start_from = ($page-1) * $num_results_on_page;  

$search_url_add = "";

if(isset($_GET['query'])){
    
    $search = $_GET['query'];
    
    $search = "user LIKE '%$search%' OR amount LIKE '%$search%'";
    
    $result = mysqli_query($con,"select * from withdraw_requests WHERE $search order by sn desc LIMIT $start_from, $num_results_on_page");
    
    $result_db = mysqli_query($con,"select COUNT(sn) from withdraw_requests AS history where $search"); 
    
    $search_url_add = "&query=".$_REQUEST['query'];
    
} else {
    
    $result = mysqli_query($con,"select * from withdraw_requests order by sn desc LIMIT $start_from, $num_results_on_page");
    
    
    $result_db = mysqli_query($con,"SELECT COUNT(sn) FROM withdraw_requests"); 
    
}

$action_url = "&page=".$page.$search_url_add;


$row_db = mysqli_fetch_row($result_db);  
$total_pages = $row_db[0];  

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;



?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Withdraw Points Request</h1>
              <form class="forms-sample" method="get" enctype="multipart/form-data" autocomplete="off"  style="margin-top:15px;">
                                  
                                  <p>Search with Mobile number, Amount</p>
                                    
                                   <div class="row">
                                       <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="query" value="<?php if(isset($_REQUEST['query'])){ echo $_REQUEST['query']; } ?>" placeholder="Enter Keyword" required>
                                            </div>
                                       </div>
                                       <div class="col-sm-4">
                                           <button type="submit" class="btn btn-primary mr-2 mt-4" style="width: 100%;margin-top: 0 !important;">Search</button>
                                       </div>
                                   </div>
                                    
                                    
                                </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Withdraw Request</li>
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
                    <button class="btn btn-primary">Withdraw Points</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="examplex1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>User Mobile</th>
                    <th>Points</th>
                    <th>Request No.</th>
                    <th>Date</th>
                    <th>Screenshot</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                        
                    $i = (($page-1)*10)+1; while ($row = mysqli_fetch_array($result)) { 
                                            
                            $user_id = $row['user'];
                                                    
                            $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$user_id' ");
                            $fetch = mysqli_fetch_array($user);
                            
                            
                            $withdraw_details = mysqli_fetch_array(mysqli_query($con,"select * from withdraw_details where user='$user_id'"));
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $fetch['name']; ?> <a href="user-profile.php?userID=<?php echo $user_id; ?>"><i class="mdi mdi-link"></i></a></td>
                                                
                            <td>
                                <?php echo $fetch['mobile']; ?>
                            </td>               
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['sn']; ?></td>
                            <td><?php echo date('h:i A d-m-Y',$row['created_at']); ?></td>
                          <td><a target="_blank" href="<?php echo $row['screenshot_with']; ?>"><img src="<?php echo $row['screenshot_with']; ?>" style="width:100px;"/></a></td>
                            <td>
                                <?php
                                    if($row['status'] == 1){
                                        echo "<span class='badge badge-success'>Accepted</span>";  
                                    }elseif($row['status'] == 0){
                                        echo "<span class='badge badge-warning'>Pending</span>"; 
                                    }else{
                                        echo "<span class='badge badge-danger'>Rejected</span>";    
                                    }
                                ?>
                            </td>
                            <td class="text-center">
                                <a href="#ViewRequest<?php echo $i; ?>" data-toggle="modal" style="font-size:20px;"><i class="fas fa-eye"></i></a>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 0){ ?>
                                <a href="#RequestApproved<?php echo $i; ?>" data-toggle="modal" class="btn btn-success mb-4">Approved</a>
                                <a href="#RequestRejected<?php echo $i; ?>" data-toggle="modal" class="btn btn-danger">Rejected</a>
                                <?php } else { echo "Action taken"; } ?>
                            </td>
                        </tr>
                                            
                                            
                        <!--View Withdraw Request-->
                        <div class="modal fade" id="ViewRequest<?php echo $i; ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                              
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Withdraw Request Details</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                                
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3 border"><b>User Name</b></div>
                                            <div class="col-sm-3 border">
                                                <?php echo $fetch['name']; ?> <a href="user-profile.php?userID=<?php echo $user_id; ?>"><i class="mdi mdi-link"></i></a>
                                            </div>
                                             <div class="col-sm-3 border"><b>Request Points</b></div>
                                            <div class="col-sm-3 border"><?php echo $row['amount']; ?></div>
                                            <div class="col-sm-3 border"><b>Request Number</b></div>
                                            <div class="col-sm-3 border">#<?php echo $row['sn']; ?></div>
                                            <div class="col-sm-3 border"><b>Payment Method</b></div>
                                            <div class="col-sm-3 border"><span class="badge badge-success"><?php echo $row['mode']; ?></span></div>
                                            <div class="col-sm-3 border"><b>Paytm</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $withdraw_details['paytm']; ?></span></div>
                                            <div class="col-sm-3 border"><b>GPay</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $withdraw_details['gpay']; ?></span></div>
                                            <div class="col-sm-3 border"><b>Phonpe</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $withdraw_details['phonepe']; ?></span></div>
                                            <div class="col-sm-3 border"><b>A/C no</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $withdraw_details['ac']; ?></span></div>
                                            <div class="col-sm-3 border"><b>A/C Holder Name</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $withdraw_details['holder']; ?></span></div>
                                            <div class="col-sm-3 border"><b>IFSC</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $withdraw_details['ifsc']; ?></span></div>
                                            <div class="col-sm-3 border"><b>Request Date</b></div>
                                            <div class="col-sm-3 border"><?php echo date('h:i A d-m-Y',$row['created_at']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                          
                        <!--Request Rejected-->
                        <div class="modal fade" id="RequestRejected<?php echo $i; ?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                  
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Request Approved</h4>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <form method="post" autocomplete="off" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" value="<?php echo $row['sn']; ?>" required/>
                                                            <input type="hidden" name="txn_id" value="<?php echo $row['sn']; ?>" required/>
                                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" required/>
                                                           
                                                            <div class="form-group">
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-success" type="submit" name="requestRejected">Rejected</button>
                                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            
                                            
                        <!--Request Approved-->
                        <div class="modal fade" id="RequestApproved<?php echo $i; ?>" enctype="multipart/form-data" enctype="multipart/form-data">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                  
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Request Approved</h4>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <form method="post" autocomplete="off" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" value="<?php echo $row['sn']; ?>" required/>
                                                             <div class="form-group">
                                                                <label>Select Image</label>
                                                                <input type="file" class="form-control" name="fileToUpload"  />
                                                            </div>
                                                            <div class="form-group">
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-success" type="submit" name="requestApproved">Approved</button>
                                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                    <?php
                            $i++;
                        }
                    ?>
                  </tbody>
                </table>
                    <?php if (ceil($total_pages / $num_results_on_page) > 0): 
                                    
                                     ?>
                <ul class="pagination">
                  <?php if ($page > 1): ?>
                  <li class="prev page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page-1 ?><?php echo $search_url_add; ?>">Prev</a></li>
                  <?php endif; ?>

                  <?php if ($page > 3): ?>
                  <li class="start page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=1<?php echo $search_url_add; ?>">1</a></li>
                  <li class="dots page-item">...</li>
                  <?php endif; ?>

                  <?php if ($page-2 > 0): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page-2 ?><?php echo $search_url_add; ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                  <?php if ($page-1 > 0): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page-1 ?><?php echo $search_url_add; ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                  <li class="currentpage page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page ?><?php echo $search_url_add; ?>"><?php echo $page ?></a></li>

                  <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page+1 ?><?php echo $search_url_add; ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                  <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page+2 ?><?php echo $search_url_add; ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                  <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                  <li class="dots page-item">...</li>
                  <li class="end page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo ceil($total_pages / $num_results_on_page) ?><?php echo $search_url_add; ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                  <?php endif; ?>

                  <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                  <li class="next page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page+1 ?><?php echo $search_url_add; ?>">Next</a></li>
                  <?php endif; ?>
                </ul>
                <?php endif; ?>
                
                
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
    
<?php

    if(isset($_POST['requestRejected'])){
        $id = $_POST['id'];
        $remark = $_POST['remark'];
        $createDate = date("Y-m-d H:i:s");
        $txnID = $_POST['txn_id'];
        $userID = $_POST['user_id'];
        
        mysqli_query($con,"update withdraw_requests set status='2' where sn='$id'");
        
        $info = mysqli_fetch_array(mysqli_query($con,"select user, amount from withdraw_requests where sn='$id'"));
        $mobile = $info['user'];
        $amount = $info['amount'];
        
        mysqli_query($con,"UPDATE users set wallet=wallet+$amount where mobile='$mobile'");
    
        $withdrawUpdate = mysqli_query($con,"INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('$mobile','$amount','1','Withdraw cancelled by our team','user','$stamp','0','0')");
  
       
                                                    
        if($withdrawUpdate){
             echo "<script>window.location.href= 'withdraw-points-request.php';</script>";
            // $walletRowDelete = mysqli_query($con, "DELETE FROM `wallet` WHERE `user_id`='$userID' AND `transactionID`='$txnID'");
            // if($walletRowDelete){
            //     echo "<script>window.location.href= 'withdraw-points-request.php';</script>";
            // }
        }
    }



    // Approved request
    if(isset($_POST['requestApproved'])){
        $id = $_POST['id'];
        $remark = $_POST['remark'];
        $createDate = date("Y-m-d H:i:s");
                                                
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 // $banner_url = $_POST['banner_url'];
    
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
   
        
          $withdrawUpdate=  mysqli_query($con,"update withdraw_requests set status='1', screenshot_with='$target_file' where sn='$id'");
        //  echo "update withdraw_requests set status='1', screenshot_with='$banner_url' where sn='$id'";
        // $target_dir = "images/";
        // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            
        // }
                                                                
        // $withdrawUpdate = mysqli_query($con, "UPDATE `withdraw_point_request` SET `remark`='$remark',`accept_date`='$createDate',`payment_receipt`='$target_file',`status`='1' WHERE `id`='$id'");
                                                    
        if($withdrawUpdate){
            echo "<script>window.location.href= 'withdraw-points-request.php';</script>";
        }
    }
?>

<?php include('footer.php'); ?>