<?php include('header.php'); ?>

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
                <table id="examples1" class="table table-bordered table-striped">
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
                    
                    
                                        
                    
                    $num_results_on_page = 10;  
                    if (isset($_GET["page"])) {
                    	$page  = $_GET["page"]; 
                    	} 
                    	else{ 
                    	$page=1;
                    	};  
                    $start_from = ($page-1) * $num_results_on_page;  
                    
                    $search_url_add = "";
                    
                    $result = mysqli_query($con,"select * from transactions where remark like '%winning%' order by sn desc LIMIT $start_from, $num_results_on_page");
                    
                    
                    $result_db = mysqli_query($con,"SELECT COUNT(sn) FROM transactions where remark like '%winning%'"); 
                
                    
                    $action_url = "&page=".$page.$search_url_add;
                    
                    
                    $row_db = mysqli_fetch_row($result_db);  
                    $total_pages = $row_db[0];  
                    
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                    

                    
                         $i = (($page-1)*10)+1; while ($row = mysqli_fetch_array($result)) { 
                                            
                            $userID = $row['user'];
                            $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$userID' ");
                            $fetch = mysqli_fetch_array($user);
                                                    
                            $gameID = $row['game_id'];
                            $game = mysqli_query($con, "SELECT * FROM `games` WHERE `sn`='$gameID' ");
                            $g = mysqli_fetch_array($game);
                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $fetch['name']; ?></td>
                                <td><?php echo $g['amount']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $g['bazar']; ?></td>
                                <td><?php echo $g['game']; ?></td>
                                <td><?php echo $g['number']; ?></td>
                                <td><?php echo date('h:i A d-m-Y',$row['created_at']); ?></td>
                            </tr>
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