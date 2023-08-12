<?php include('header.php');


     $date = date('d/m/Y');
     



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
    
    $search = "user LIKE '%$search%' OR game LIKE '%$search%' OR bazar LIKE '%$search%' OR number LIKE '%$search%' OR amount LIKE '%$search%'";
    
    $result = mysqli_query($con,"select * from games WHERE ( $search ) AND date='$date' order by sn desc LIMIT $start_from, $num_results_on_page");
    
    $result_db = mysqli_query($con,"select COUNT(sn) from games AS history where  ( $search ) AND date='$date'"); 
    
    $search_url_add = "&query=".$_REQUEST['query'];
    
} else {
    
    $result = mysqli_query($con,"select * from games  WHERE date='$date' order by sn desc LIMIT $start_from, $num_results_on_page");
    
    
    $result_db = mysqli_query($con,"SELECT COUNT(sn) FROM games  WHERE date='$date'"); 
    
}

$action_url = "&page=".$page.$search_url_add;


$row_db = mysqli_fetch_row($result_db);  
$total_pages = $row_db[0];  

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;





?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bid History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Bid History</li>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" id="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>Game Name</label>
                            <select id="game_id" class="form-control select2bs4" style="width: 100%;">
                                <option value="" selected disabled>Select Game</option>
                                <?php 
                                $gameList = mysqli_query($con, "SELECT * FROM `gametime_new` WHERE `active`='1' ORDER BY sn DESC");
                                while($row = mysqli_fetch_array($gameList)){
                                    ?>
                                    <option value="<?php echo $row['market']; ?>"><?php echo $row['market']; ?></option>
                                    <?php
                                        }
                                    ?>
                                     <?php 
                                        $gameList = mysqli_query($con, "SELECT * FROM `gametime_manual` WHERE `active`='1' ORDER BY sn DESC");
                                        while($row = mysqli_fetch_array($gameList)){
                                    ?>
                                    <option value="<?php echo $row['market']; ?>"><?php echo $row['market']; ?></option>
                                    <?php
                                        }
                                    ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>Game Type</label>
                            <select class="form-control select2bs4" id="game_type" style="width: 100%;">
                                <option value="" selected disabled>Select Game Type</option>
                                <option value="single">Single Digit</option>
                                <option value="jodi">Jodi Digit</option>
                                <option value="singlepatti">Single Pana</option>
                                <option value="doublepatti">Double Pana</option>
                                <option value="triplepatti">Triple Pana</option>
                                <option value="halfsangam">Half Sangam</option>
                                <option value="fullsangam">Full Sangam</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mt-2">
                                <button id="fetchData" class="btn btn-primary mt-4">SAVE</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.card -->

        </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <button class="btn btn-primary">Bid History</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive" id="full_main">
                <table id="examplex1" class="w-100 table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Mobile Number</th>
                    <th>Bid TXID</th>
                    <th>Game Name</th>
                    <th>Game Type</th>
                    <th>Session</th>
                    <th>Number</th>
                    <th>Points</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="tbody">
                   <?php
     
    
    $i = 1;
     $i = (($page-1)*10)+1; while ($row = mysqli_fetch_array($result)) { 
        // user data
        $userID = $row['user'];
        $user = mysqli_query($con, "SELECT name,mobile FROM `users` WHERE `mobile`='$userID' ");
        $fetch = mysqli_fetch_array($user);
        
        $game_id = $row['bazar'];
?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php if($fetch['name'] != ''){ echo $fetch['name'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($fetch['mobile'] != ''){ echo $fetch['mobile'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($row['sn'] != ''){echo $row['sn'];}else{ echo 'N/A'; } ?></td>
        <td><?php echo $game_id; ?></td>
        <td style="text-transform: capitalize;"><?php if($row['game'] != ''){echo $row['game'];}else{ echo 'N/A'; } ?></td>
        <td style="text-transform: capitalize;"><?php if('' != ''){echo $row['session'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($row['number'] != ''){echo $row['number'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($row['amount'] != ''){echo $row['amount'];}else{ echo 'N/A'; } ?></td>
        <td><a class="btn btn-info" href="update-bid-history.php?id=<?php echo $row['sn']; ?>">Edit</a></td>
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
<script>

// fetch user bid history
    $('#fetchData').click(function(){
        var date = $('#date').val();
        var gameID = $('#game_id').val();
        var gameType = $('#game_type').val();
        
     //   alert(gameID);
        
        $.ajax({    //create an ajax request to display.php
            type: "POST",
            url: "bid-history-ajax.php",             
            data:{date:date, gameID:gameID, gameType:gameType},   //expect html to be returned                
            success: function(response){                    
                $("#full_main").html(response); 
             //   alert(response);
            }
        });
    });

    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>