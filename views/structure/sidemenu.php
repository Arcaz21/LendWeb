<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="c_home.php" class="site_title"><img src="../vendors/img/favicon.png" width="50px" height="50px">   Lend Web!</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $data->fname ." ". $data->lname."  "?></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li><a href="c_home.php"><i class="fa fa-home"></i> Transact </a></li>
          <li><a href="c_wallet.php"><i class="fa fa-key"></i> My Wallet  </a></li>
          <li><a href="c_lendees.php"><i class="fa fa-money"></i> Lendees </a></li>
          <li><a href="c_report.php"><i class="fa fa-pie-chart"></i> Report </a></li>
          <li><a href="c_addmem.php"><i class="fa fa-home"></i> Encode </a></li>
          <!-- <li><a href="c_accounts.php"><i class="fa fa-envelope"></i> Account </a></li> -->
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>