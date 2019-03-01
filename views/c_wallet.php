<?php 
session_start(); 
$_SESSION['page'] =  basename($_SERVER['PHP_SELF']); 
include "../controllers/transactionFunction.php"; 
$db = new userModel();
$data =$db->getuser($_SESSION['username']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lend Web! | REPORT</title>

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

         <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="row">

              <!-- WALLET -->
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="x_panel ui-ribbon-container">
                          <div class="x_title">
                            <h2>Wallet Balance</h2>
                            <div class="clearfix"></div>
                          </div>
                           <div class="x_content">

                            <div style="text-align: center; margin-bottom: 17px">
                              <span>On-hand Money Today</span>
                              <?php if($grandtotal->TotalWallet < 0){?> 
                              <h1 style="color:red;"><?php echo "₱".$grandtotal->TotalWallet?></h1>
                              <?php }else{ ?>
                              <h1 style="color:rgb(38,185,154);"><?php echo "₱ ".$grandtotal->TotalWallet?></h1>
                              <?php }?>
                            </div>

                            <h3 class="name_title"></h3>
                            <div class="divider"></div>
                          </div>
                        </div>
              </div>
              <!-- #END WALLET -->

              <!-- LOANS -->
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="x_panel ui-ribbon-container">
                          <div class="x_title">
                            <h2>Loans</h2>
                            <div class="clearfix"></div>
                          </div>
                           <div class="x_content">

                            <div style="text-align: center; margin-bottom: 17px">
                              <span>Expected Collection Today</span>
                             <h1 style="color:rgb(38,185,154); "><?php echo "₱ ".$getexpectedcollection[0]['TotalCollection'] ?></h1>
                            </div>

                            <h3 class="name_title"></h3>
                            <div class="divider"></div>
                          </div>
                        </div>
              </div>
              <!-- #END LOANS -->

              <!-- Total Collection -->
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="x_panel ui-ribbon-container">
                          <div class="x_title">
                            <h2>Loans</h2>
                            <div class="clearfix"></div>
                          </div>
                           <div class="x_content">

                            <div style="text-align: center; margin-bottom: 17px">
                              <span>Current Collection Today</span>
                             <h1 style="color:rgb(38,185,154); "><?php echo "₱ ".$currtotalcollection[0]['TotalCollection'] ?></h1>
                            </div>

                            <h3 class="name_title"></h3>
                            <div class="divider"></div>
                          </div>
                        </div>
              </div>
              <!-- #END Total Collection -->

              <!-- MISSED -->
              <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="x_panel ui-ribbon-container">
                  <div class="x_title">
                    <h2>Missed Payemnts</h2>
                    <div class="clearfix"></div>
                  </div>
                   <div class="x_content">

                    <div style="text-align: center; margin-bottom: 17px">
                      <span>Current Missed Payment</span>
                     <h1 style="color:red; "></h1>
                    </div>

                    <h3 class="name_title"></h3>
                    <div class="divider"></div>
                  </div>
                </div>
              </div> -->
              <!-- #END MISSED -->

              <!-- EXPENSES -->
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="x_panel ui-ribbon-container">
                  <div class="x_title">
                    <h2>Expenses</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div style="text-align: center; margin-bottom: 17px">
                      <span>Total Expenses Today</span>
                     <h1 style="color:red; "><?php echo "₱ ".$gettotalexpenses->exptotal; ?></h1>
                    </div>

                    <div class="divider"></div>
                    <!-- MODAL -->
                    <div style="text-align: center;">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm"><span class="fa fa-plus-circle"></span> Expenses </button>

                      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                              <h4 class="modal-title" id="myModalLabel2">Add Expenses</h4>
                            </div>
                            <form action="<?php $_PHP_SELF ?>" method="POST">
                              <div class="modal-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input required type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Reference Number" name="refnumber" id="refnumber">
                                  <span class="fa fa-barcode form-control-feedback left required" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input required type="number" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Amount" name="amount" id="amount">
                                  <span class="fa fa-money form-control-feedback left required" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input required type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Purpose" name="purpose" id="purpose">
                                  <span class="fa fa-comments-o form-control-feedback left required" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input required type="password" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Password" name="pwd" id="pwd">
                                  <span class="fa fa-exclamation form-control-feedback left required" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <input hidden="" name="uid" value="<?php echo $data->user_id; ?>" >
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                              <button  type="submit" name="submit" value="addexp" class="btn btn-primary">Add Expense</button>
                            </div>
                            </form>

                          </div>
                        </div>
                      </div>
                    </div>
                      <!-- #END OF MODAL -->
                  </div>
                </div>
              </div>
              <!-- #END EXPENSES -->


            </div>
        </div>

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
    <script src="../build/js/custom.js"></script>
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
                text: 'Successfully Added Expenses',
                type: 'success',
                styling: 'bootstrap3'
              });
          }
          if(message == "passworderror") {
              new PNotify({
                title: 'Password Error',
                text: 'The password you entered does not match.',
                type: 'error',
                styling: 'bootstrap3'
              });
          } 
          else {
              new PNotify({
                  title: 'Popup Title',
                  text: 'Whops, you messed up'
              }); 
          }
      }
    </script>
    <?php unset($_SESSION['script']); ?>

  </body>
</html>