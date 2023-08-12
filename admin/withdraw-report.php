<?php include('header.php'); ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Withdraw Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Withdraw Report</li>
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
                    <button class="btn btn-primary">Withdraw Report</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="examplex1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Mobile Number</th>
                    <th>Points</th>
                    <th>Request No.</th>
                    <th>Date</th>
                    <th>Screenshot</th>
                    <th>Status</th>
                    <th>View</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                        
                        $num_results_on_page = 10;  
                        if (isset($_GET["page"])) {
                        	$page  = $_GET["page"]; 
                        	} 
                        	else{ 
                        	$page=1;
                        	};  
                        $start_from = ($page-1) * $num_results_on_page;  
                        
                        $search_url_add = "";
                        
                        $result = mysqli_query($con,"select * from withdraw_requests  WHERE `status`='1' order by sn desc LIMIT $start_from, $num_results_on_page");
                            
                        $result_db = mysqli_query($con,"SELECT COUNT(sn) FROM withdraw_requests  WHERE `status`='1'"); 
                        
                        $action_url = "&page=".$page.$search_url_add;
                        
                        
                        $row_db = mysqli_fetch_row($result_db);  
                        $total_pages = $row_db[0];  
                        
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                        
                        

                    
                    
                    
                         $i = (($page-1)*10)+1; while ($row = mysqli_fetch_array($result)) { 
                            $user_id = $row['user'];
                                                    
                            $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$user_id' ");
                            $fetch = mysqli_fetch_array($user);
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
                          <td><a  target="_blank" href="<?php echo $row['screenshot_with']; ?>"><img src="<?php echo $row['screenshot_with']; ?>" style="width:100px;"/></a></td>
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
                                            <div class="col-sm-3 border"><span ><?php echo $row['paytm']; ?></span></div>
                                            <div class="col-sm-3 border"><b>Phonpe</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $row['phonepe']; ?></span></div>
                                            <div class="col-sm-3 border"><b>A/C no</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $row['ac']; ?></span></div>
                                            <div class="col-sm-3 border"><b>A/C Holder Name</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $row['holder']; ?></span></div>
                                            <div class="col-sm-3 border"><b>IFSC</b></div>
                                            <div class="col-sm-3 border"><span ><?php echo $row['ifsc']; ?></span></div>
                                            <div class="col-sm-3 border"><b>Request Date</b></div>
                                            <div class="col-sm-3 border"><?php echo date('h:i A d-m-Y',$row['created_at']); ?></div>
                                        </div>
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

<?php include('footer.php'); ?>