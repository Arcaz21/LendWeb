<?php 
session_start();  
if( !isset($_SESSION['username']) && !isset($_SESSION['password'])){
  header("location: ../index.php");
}
$_SESSION['page'] =  basename($_SERVER['PHP_SELF']);
include "../controllers/transactionFunction.php";
$db = new userModel();
$data =$db->getuser($_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lend Web! | LENDEES</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <!-- FAVICON-->
    <link rel="icon" href="..vendors/img/favicon.png">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        
        <?php include "structure/sidemenu.php" ?>
        <?php include "structure/topnav.php" ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Payment Page</h2>
                    <div class="clearfix"></div>
                  </div>
                      <!-- modals -->
                        <!-- Small modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Scan QR Code</button>
                        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Place QR Code in the Center</h4>
                              </div>
                              <div class="modal-body">
                              <center>
                              fsdfdsfds
                              </center>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>

                            </div>
                          </div>
                        </div>
                      <!-- /modals -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Member ID</th>
                          <th>Full Name</th>
                          <th>Contact</th>
                          <th>Remaining Balance</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php error_reporting(E_ERROR | E_PARSE); foreach ($getmembers as $index => $members):  ?>
                        <tr>
                          <td><?php echo $members['memberID'];?></td>
                          <td><?php echo $members['fname']." ".$members['mname']." ".$members['lname'];?></td>
                          <td><?php echo $members['contact'];?></td>
                          <td><?php echo $members['balance'];?></td>
                          <td>
                            <form action="<?php $_PHP_SELF ?>" method="POST">
                                <input required="required"  name="payment" type="number" step='0.01'  placeholder='0.00' >
                                <input  hidden="hidden" name="memberID" value="<?php echo $members['memberID']; ?>" >
                                <button name="submit" value="pay" type="submit" class="btn btn-success">PAY</button>
                            </form>
                           </td>
                        </tr>
                      <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
     <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <?php $notify = isset($_SESSION['script'])?$_SESSION['script']:NULL; print_r($notify); ?>
    <script type="text/javascript">
      function notifyUser(message) {
          if(message == "success") {
              new PNotify({
                title: 'Adding Success',
                text: 'Successfully Added Payment',
                type: 'success',
                styling: 'bootstrap3'
              });
          } else {
              new PNotify({
                  title: 'Popup Title',
                  text: 'Whops, you messed up'
              }); 
          }
      }
    </script>
    <?php unset($_SESSION['script']); ?>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.js"></script>

  </body>
</html>