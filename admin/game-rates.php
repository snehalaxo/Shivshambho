<?php include('header.php'); 

$select = mysqli_query($con, "SELECT * FROM `rate` ");
$row = mysqli_fetch_array($select);
    
    if(isset($_POST['submit'])){
        $singleDigit1 = $_POST['singleDigit1']/10;
       // $singleDigit2 = $_POST['singleDigit2'];
        $jodiDigit1 = $_POST['jodiDigit1']/10;
        //$jodiDigit2 = $_POST['jodiDigit2'];
        $singlePana1 = $_POST['singlePana1']/10;
        //$singlePana2 = $_POST['singlePana2'];
        $doublePana1 = $_POST['doublePana1']/10;
    //    $doublePana2 = $_POST['doublePana2'];
        $triplePana1 = $_POST['triplePana1']/10;
      //  $triplePana2 = $_POST['triplePana2'];
        $halfSangam1 = $_POST['halfSangam1']/10;
//        $halfSangam2 = $_POST['halfSangam2'];
        $fullSangam1 = $_POST['fullSangam1']/10;
  //      $fullSangam2 = $_POST['fullSangam2'];
        
        $update = mysqli_query($con, "UPDATE `rate` SET 
                                            `single`='$singleDigit1',
                                            `jodi`='$jodiDigit1',
                                            `singlepatti`='$singlePana1',
                                            `doublepatti`='$doublePana1',
                                            `triplepatti`='$triplePana1',
                                            `halfsangam`='$halfSangam1',
                                            `fullsangam`='$fullSangam1'
                                            ");
      $singleDigit1 = "10/".($singleDigit1*10);
      $jodiDigit1 = "10/".($jodiDigit1*10);
      $singlePana1 = "10/".($singlePana1*10);
      $doublePana1 = "10/".($doublePana1*10);
      $triplePana1 = "10/".($triplePana1*10);
      $halfSangam1 = "10/".($halfSangam1*10);
      $fullSangam1 = "10/".($fullSangam1*10);
       $update = mysqli_query($con, "UPDATE `rates` SET 
                                            `single`='$singleDigit1',
                                            `jodi`='$jodiDigit1',
                                            `singlepatti`='$singlePana1',
                                            `doublepatti`='$doublePana1',
                                            `triplepatti`='$triplePana1',
                                            `halfsangam`='$halfSangam1',
                                            `fullsangam`='$fullSangam1'
                                            ");
        if($update){
            echo "<script>window.location.href='game-rates.php';</script>";
        }
    }
?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Game Rates</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Game Rates</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- Form Element sizes -->
                <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Game Rates</h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                    <h4>Single Digit</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['single']*10; ?>" name="singleDigit1" required />
                                        </div>
                                        
                                    </div>
                                    
                                    <h4>Jodi Digit</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['jodi']*10; ?>" name="jodiDigit1" required />
                                        </div>
                                      
                                    </div>
                                    
                                    <h4>Single Pana</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['singlepatti']*10; ?>" name="singlePana1" required />
                                        </div>
                                       
                                    </div>
                                    
                                    <h4>Double Pana</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['doublepatti']*10; ?>" name="doublePana1" required />
                                        </div>
                                       
                                    </div>
                                    
                                    <h4>Triple Pana</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['triplepatti']*10; ?>" name="triplePana1" required />
                                        </div>
                                       
                                    </div>
                                    
                                    <h4>Half Sangam</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['halfsangam']*10; ?>" name="halfSangam1" required />
                                        </div>
                                        
                                    </div>
                                    
                                    <h4>Full Sangam</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="mb-2 mr-sm-2">Value:</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" value="<?php echo $row['fullsangam']*10; ?>" name="fullSangam1" required />
                                        </div>
                                        
                                    </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <div class="col-md-2"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<?php include('footer.php'); ?>
