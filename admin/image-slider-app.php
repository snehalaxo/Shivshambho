<?php include('header.php'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Image Slider</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Image Slider</li>
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
                    <a href="#AddNewGame" data-toggle="modal" class="btn btn-primary">Add Image</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Redirect</th>
                    <th>Redirect to</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $game = mysqli_query($con, "SELECT * FROM `image_slider` ORDER BY sn ASC");
                    $i = 1;
                    while($row = mysqli_fetch_array($game)){
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      
                      <td> <a href="<?php echo $row['image']; ?>"><img src="<?php echo $row['image']; ?>" style="height:100px" /></a></td>
                      <td><?php if($row['verify']=="1"){ echo "Verified"; } else { echo "Unverified"; } ?></td>
                      <td><?php echo $row['refer']; ?></td>
                      <td><?php echo $row['data']; ?></td>
                      <td>
                          
                        <a href="image-slider-app.php?Delete=<?php echo $row['sn']; ?>" class="btn btn-sm btn-danger">Delete</a>
                      </td>
                      
                    </tr>

                  <!-- Edit Game -->
                  <?php
                    $i++;
                    }

                    // Edit Game
                    if(isset($_GET['Delete'])){
                      $gameID = $_GET['Delete'];
                      
                      $updateGame = mysqli_query($con, "DELETE FROM `image_slider` WHERE `sn`='$gameID'");
                      if($updateGame){
                          echo "<script>window.location.href='image-slider-app.php';</script>";
                      }
                      
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

<!-- Add New Game -->
<div class="modal fade" id="AddNewGame">
    <div class="modal-dialog">
        <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 class="modal-title">Add New Image</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST"  enctype="multipart/form-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Image</label>
                        <input type="file" class="form-control" name="fileToUpload" required />
                    </div>
                    
                
                  
                     <div class="form-group">
                                <label>Image Type</label>
                                <select id="verify" name="verify" class="form-control" style="width: 100%;">
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="1">Verified uses</option>
                                    <option value="0">Unverified users</option>
                                </select>
                            </div>
                  
                   			<div class="form-group">
                                <label>Redirect Type</label>
                                <select id="redirect" name="redirect" class="form-control" onchange='redirect_sel(this.value)' style="width: 100%;">
                                    <option value="" selected>No Redirect</option>
                                    <option value="market">Market Redirect</option>
                                    <option value="refer">Refer Redirect</option>
                                    <option value="url">URL Redirect</option>
                                </select>
                            </div>
                  <script>
                    function redirect_sel(refer){
                      
                      if(refer == 'market'){
                       $('#market_block').show();
                       $('#url_block').hide();
                      } else if(refer == 'url'){
                       $('#market_block').hide();
                       $('#url_block').show();
                      } else {
                        $('#market_block').hide();
                       $('#url_block').hide();
                      }
                    }
                  </script>
                  
                   <div class="col-md-12" id='market_block' style="display:none;">
                            <div class="form-group">
                            <label>Game Name</label>
                            <select id="game_id" name='game_id' class="form-control select2bs4" style="width: 100%;">
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
                  
                   <div class="form-group"  id='url_block' style="display:none;">
                        <label>Enter URL</label>
                        <input type="text" class="form-control" name="url"  />
                    </div>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" name="CreateNew" class="btn btn-outline-light">Save changes</button>
                </div>
            </form>
        </div>
          <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>

<?php 

if(isset($_POST['CreateNew'])){
   
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  $verify = $_REQUEST['verify'];
  $redirect = $_REQUEST['redirect'];
  
  if($redirect == "market"){
   $data = $_REQUEST['game_id'];
  } else if($redirect == "url"){
   $data = $_REQUEST['url'];
  } else {
    $data = "";
  }
    
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

  $insert = mysqli_query($con, "INSERT INTO `image_slider`( `image`,`verify`,`refer`,`data`) 
                                                          VALUES ('$target_file','$verify','$redirect','$data')");
      if($insert){
          echo "<script>window.location.href = 'image-slider-app.php';</script>";
      }else{
          echo "<script>alert('Server Error. Please try again after some time!!');</script>";
      }
  
}

include('footer.php'); 
?>