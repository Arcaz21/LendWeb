<?php 
//get the last-modified-date of this very file
$lastModified=filemtime(__FILE__);
//get a unique hash of this file (etag)
$etagFile = md5_file(__FILE__);
//get the HTTP_IF_MODIFIED_SINCE header if set
$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

//set last-modified header
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
//set etag-header
header("Etag: $etagFile");
//make sure caching is turned on
header('Cache-Control: public');

//check if page has changed. If not, send 304 and exit
if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
{
       header("HTTP/1.1 304 Not Modified");
       exit;
}session_start();  
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
                    <h2>List of Lendees</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="x_content">
                    <button type="button" class="btn btn-default"><a href="c_addlend.php"><i class="fa fa-plus-circle"></i>  Add Lendee </a></button>
                    <div class="clearfix"></div>
                    </div>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Member ID</th>
                          <th>Username</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Middle Name</th>
                          <th>Contact</th>
                          <th>Address</th>
                          <th>Rating</th>
                          <th>Register Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php error_reporting(E_ERROR | E_PARSE); foreach ($getmembers as $index => $members):  ?>
                        <tr>
                          <td><?php echo $members['memberID'];?></td>
                          <td><?php echo $members['username'];?></td>
                          <td><?php echo $members['fname'];?></td>
                          <td><?php echo $members['lname'];?></td>
                          <td><?php echo $members['mname'];?></td>
                          <td><?php echo $members['contact'];?></td>
                          <td><?php echo $members['address'];?></td>
                          <td><?php echo $members['rating'];?></td>
                          <td><?php echo $members['regDate'];?></td>
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

  </body>
</html>