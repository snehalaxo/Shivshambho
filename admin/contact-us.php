<?php include('header.php'); ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contact Us</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Contact Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- Form Element sizes -->
                <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Contact Details</h3>
                </div>
                <?php
                  $select  = mysqli_query($con, "SELECT * FROM `settings` where data_key='whatsapp' ");
                  $row = mysqli_fetch_array($select);
                  $count = mysqli_num_rows($select);
                ?>
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                           
                            <div class="form-group">
                                <label for="exampleInputEmail1">WhatsApp Number</label>
                                <input type="number" min="0" value="<?php echo $row['data'];  ?>" name="whatsapp" maxlength="10" class="form-control" placeholder="Enter WhatsApp Number" required />
                            </div>
                          
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" name="AddValues" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <?php
                  if(isset($_POST['AddValues'])){
                    $whatsapp = $_POST['whatsapp'];
                                        
                                        
                                        
                  
                      $update = mysqli_query($con, "UPDATE `settings` SET `data`='$whatsapp' WHERE `data_key`='whatsapp'");
                      if($update){
                        echo "<script>window.location.href= 'contact-us.php';</script>";
                      }
                                            
                    
                  }
                ?>

            </div>
            <div class="col-md-3"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<?php include('footer.php'); ?>
