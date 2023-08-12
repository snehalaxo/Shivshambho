<?php include('header.php');


if (isset($_REQUEST['submit']))
{
    extract($_REQUEST);
    
    $msg = array
    (
        'body'  => $body,
        'title'     => $title,
        'vibrate'   => 1,
        'sound'     => 1,
    );
    
    $data['body'] = $body;
    $data['title'] = $title;
    
    $fields = array
    (
        'to'  => '/topics/all',
        'notification'  => $msg,
        'data' => $data
    );
    
    $headers = array
    (
        'Authorization: key=AAAAC3HFcJA:APA91bFj8a7_ZRcvZPq21brX7dlqhWV92CiD2jrqJZRqdCK4L7RZoIanRM_Gpw_f_DzH0tFK4Awph2lsKiNXLTiKU9FFMMk5hLRFhPAGhpqP7K9nadkrO79COvgW1MIPGsHIZTSHCwo4',
        'Content-Type: application/json'
    );
    
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    
    $success = "Notification sent successfully";
}


?>



<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Send Notification</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Send Notification</li>
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
              <div class="card-header bg-danger">
                   Send Notification
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                   <?php if(isset($success)) { ?>
                                
                                    <div class="alert alert-success" role="alert">
                                      <?php echo $success; ?>
                                    </div>
                                
                                <?php } ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <form method="post">
                          
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Title" required/>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="" rows="5" class="form-control" name="body"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3"></div>
                </div>
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
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>