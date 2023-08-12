<?php include('header.php'); ?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Notice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- Form Element sizes -->
                <?php
                  $select = mysqli_query($con, "SELECT * FROM `content` ");
                  $row = mysqli_fetch_array($select);
                ?>
                <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Notice</h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                           
                            <div class="form-group">
                                <label>Notice Content</label>
                                <textarea name="content" id="content" rows="5" class="form-control"><?php echo $row['notice']; ?></textarea>
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
                <?php
                  if(isset($_POST['submit'])){
                    $content = $_POST['content'];
                     $update = mysqli_query($con, "UPDATE `content` SET `notice`='$content'");
                      if($update){
                        echo "<script>window.location.href='notice.php';</script>";
                      }

                  }
                ?>

            </div>
            <div class="col-md-1"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
    
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
 <script>
        CKEDITOR.replace( 'content' );
</script>



<?php include('footer.php'); ?>
