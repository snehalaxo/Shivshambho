<?php include('header.php'); ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Starline Sell Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Starline Sell Report</li>
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
                                <label>Date</label>
                                <input type="date" id="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Game Name</label>
                            <select id="gameId" class="form-control select2bs4" style="width: 100%;">
                                <option value="" selected disabled>Select Game</option>
                                <?php
                                    $game = mysqli_query($con, "SELECT * FROM `starline_game_list` ORDER BY id DESC");
                                                    
                                    while($row = mysqli_fetch_array($game)){
                                                        
                                ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['game_name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
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

    <!-- Main content -->
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
              <div class="card-body" id="report">
                
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
// fetch sell report
$('#go').click(function(){
    var date = $('#date').val();
    var gameID = $('#gameId').val();
    
    if(date != '' && gameID != ''){
        $.ajax({    //create an ajax request to 
            type: "POST",
            url: "starline-sell-report-ajax.php",             
            data:{ResultDate:date, gameID:gameID},  //expect html to be returned                
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