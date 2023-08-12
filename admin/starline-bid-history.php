<?php include('header.php'); ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Starline Bid History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Starline Bid History</li>
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
                            <select class="form-control select2bs4" id="game_id" style="width: 100%;">
                                <option value="" selected disabled>Select Game</option>
                                <?php 
                                $gameList = mysqli_query($con, "SELECT * FROM `starline_markets` WHERE `active`='1' ORDER BY sn DESC");
                                while($rowx = mysqli_fetch_array($gameList)){
                                    
                                    $name = $rowx['name'];
                                    
                                    $gameListx = mysqli_query($con, "SELECT * FROM `starline_timings` WHERE market='$name'");
                                while($row = mysqli_fetch_array($gameListx)){
                                    
                                    $name = $row['name'];
                            ?>
                            <option value="starline_<?php echo $row['market']; ?>_<?php echo $row['close']; ?>"><?php echo $row['market'].' '.$row['close']; ?></option>
                            <?php
                                } }
                            ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>Game Type</label>
                            <select id="game_type" class="form-control select2bs4" style="width: 100%;">
                                <option value="" selected disabled>Select Game Type</option>
                                <option value="single">Single Digit</option>
                                <option value="singlepatti">Single Pana</option>
                                <option value="doublepatti">Double Pana</option>
                                <option value="triplepatti">Triple Pana</option>
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
                    <button class="btn btn-primary">Starline Bid History</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Mobile Number</th>
                    <th>Bid TXID</th>
                    <th>Game Name</th>
                    <th>Game Type</th>
                    <th>Number</th>
                    <th>Points</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="tbody">
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
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
<script>
// fetch user bid history
    $('#fetchData').click(function(){
        var date = $('#date').val();
        var gameID = $('#game_id').val();
        var gameType = $('#game_type').val();
        
        $.ajax({    //create an ajax request to display.php
            type: "POST",
            url: "starline-bid-history-ajax.php",             
            data:{date:date, gameID:gameID, gameType:gameType},   //expect html to be returned                
            success: function(response){                    
                $("#tbody").html(response); 
               // alert(response);
            }
        });
    });

    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>