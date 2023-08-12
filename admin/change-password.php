<?php include('header.php'); 

    if(isset($_POST['ChangePassword'])){
        $oldPass = $_POST['Oldpassword'];
        $NewPass = $_POST['Newpassword'];
        $ConfirmPass = $_POST['Confirmpassword'];
        
            if($NewPass == $ConfirmPass){
                $insert = mysqli_query($con, "UPDATE `admin` SET `password`='$NewPass' WHERE `password`='$oldPass'");
                if($insert){
                    echo "<script>alert('Your password successfully changed!!');</script>";
                    echo "<script>window.location.href= 'change-password.php';</script>";
                }else{
                    echo "<script>alert('Server error. Please try again after some time..');</script>";
                }
            }else{
                echo "<script>alert('Your password does not match. Please try again..!!');</script>";
            }
        
    }

?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
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
                    <h3 class="card-title">Change Password</h3>
                </div>
                <form class=""  method="post">
                                    <div class="row p-b-30">
                                        <div class="col-12">
                                            <div class="input-group mb-3">
                                                <input type="password" name="Oldpassword" class="form-control form-control-lg" placeholder="Old Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                            </div>
                                            
                                            <div class="input-group mb-3">
                                                <input type="password" name="Newpassword" class="form-control form-control-lg" placeholder="New Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                            </div>
                                            
                                            <div class="input-group mb-3">
                                                <input type="password" name="Confirmpassword" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="p-t-20">
                                                    <button class="btn btn-success float-right" name="ChangePassword" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                <!-- /.card-body -->
                </div>
                

            </div>
            <div class="col-md-3"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<?php include('footer.php'); ?>