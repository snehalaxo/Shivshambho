<?php include('header.php'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Starline Winning History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Starline Win History</li>
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
                    <th>Game Name</th>
                    <th>Pana</th>
                    <th>Digit</th>
                    <th>Game Type</th>
                    <th>Bid TXID</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                        $winning = mysqli_query($con, "SELECT * FROM `starline_winning_history` ORDER BY id DESC");
                        $i = 1;
                        while($row = mysqli_fetch_array($winning)){
                            $userID = $row['user_id'];
                            $user = mysqli_query($con, "SELECT * FROM `users` WHERE `user_id`='$userID' ");
                            $fetch = mysqli_fetch_array($user);
                                                    
                            $gameID = $row['game_id'];
                            $game = mysqli_query($con, "SELECT * FROM `starline_game_list` WHERE `id`='$gameID' ");
                            $g = mysqli_fetch_array($game);
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $fetch['name']; ?></td>
                            <td><?php echo $row['bid_points']; ?></td>
                            <td><?php echo $row['winning_points']; ?></td>
                            <td><?php echo $g['game_name']; ?></td>
                            <td><?php echo $row['open_pana']; ?></td>
                            <td><?php echo $row['open_digit']; ?></td>
                            <td><?php echo $row['game_type']; ?></td>
                            <td><?php echo $row['bid_tx_id']; ?></td>
                            <td><?php echo $row['date']; ?></td>
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

<?php include('footer.php'); ?>