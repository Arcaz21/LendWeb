<?php 
session_start();  
if( !isset($_SESSION['username']) && !isset($_SESSION['password'])){
  header("location: ../index.php");
} 
include "../controllers/encodingFunction.php"; 
$db = new userModel();
$data =$db->getuser($_SESSION['username']);
$_SESSION['page'] =  basename($_SERVER['PHP_SELF']); 
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
	  
    <title>Lend Web! | Add Account</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
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
                    <h2>Add Account</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="<?php $_PHP_SELF ?>" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    
                    <div class="form-group">
                        <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">Record Date<span class="required">*</span>
                        </label>
                        <div style ="margin-left: 26%;" class="col-md-3 col-sm-6 col-xs-12 input-group date" id="myDatepicker">
                            <input placeholder="Date sa papel na e-encode." name="inidate"  required="required"  type="text" class="form-control col-md-6 col-xs-12">
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">Start Date<span class="required">*</span>
                        </label>
                        <div style ="margin-left: 26%;"class="col-md-3 col-sm-6 col-xs-12 input-group date" id="datetimepicker6">
                            <input placeholder="Adlaw nga nag sugod ang utang." name="sdate"  required="required"  type="text" class="form-control col-md-6 col-xs-12">
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">Due Date<span class="required">*</span>
                        </label>
                        <div style ="margin-left: 26%;" class="col-md-3 col-sm-6 col-xs-12 input-group date" id="datetimepicker7">
                            <input placeholder="Adlaw nga ma human ang utang." name="ddate"  required="required"  type="text" class="form-control col-md-6 col-xs-12">
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fname"> First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="fname" type="text" id="fname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lname"> Last Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="lname" type="text" id="lname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lname"> Middle Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="mname" type="text" id="mname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lname"> Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="address" type="text" id="address" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lname"> Contact # <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="contact" type="number" id="contact" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment"> Initial Credit
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Pila una nga gi utang. ex. 1000" name="inipayment" type="text" id="inipayment" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="daily"> Daily <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="dailyP" type="text" id="daily" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment"> Payment
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="payment" type="text" id="payment" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="balance"> Balance <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="balance" type="text" id="balance" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bal_ap"> Balance AP 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="advbal" type="text" id="bal_ap" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="status" class="form-control">
                            <option value="uncleared">Uncleared</option>
                            <option value="cleared">Cleared</option>
                            <option value="overdue">Overdue</option>
                          </select>
                        </div>
                      </div>

                      <input name="encoder" type="hidden" id="bal_ap" required="required" value="<?php echo $data->fname." ".$data->lname ?>">

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-default"><a href="c_home.php"> Cancel </a></button>
                          <button class="btn btn-default"><a href="c_addmem.php"> Reset </a></button>
                          <input hidden="hidden" name="action" value="addmem" >
                          <button name="submit" value="encode" type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>

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
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
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
                text: 'Successfully Added Member, Account and Record',
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
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>    
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    
    <script>
      $('#myDatepicker').datetimepicker();
      
      $('#myDatepicker2').datetimepicker({
          format: 'DD.MM.YYYY'
      });
      
      $('#myDatepicker3').datetimepicker({
          format: 'hh:mm A'
      });
      
      $('#myDatepicker4').datetimepicker({
          ignoreReadonly: true,
          allowInputToggle: true
      });

      $('#datetimepicker6').datetimepicker();
      
      $('#datetimepicker7').datetimepicker({
          useCurrent: false
      });
      
      $("#datetimepicker6").on("dp.change", function(e) {
          $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
      });
      
      $("#datetimepicker7").on("dp.change", function(e) {
          $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
      });
    </script>
   
	
  </body>
</html>
