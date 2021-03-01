<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once'header.php';?>
    </head>
    <body>
       
        <div id="fb-root"></div>
        <section class="abt-banner p-0">
          
            <div class="container h-100">
                <div class="row m-0 h-100 justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        <h3>My Profile</h3>
                    </div>
                </div>
            </div> 
        </section>
        <section class="user-dashboard">
            <div class="container">
                <div class="row m-0 rowmobile">
                    <div class="col-md-3">
                        <div class="dashboard-box"> 
                            <ul>
                                <li><a href="<?php echo base_url(); ?>userDashboardOrders" ><span class="lnr lnr-cart"></span> My Orders</a></li>
                                <li><a href="<?php echo base_url(); ?>Userdashboard"><span class="lnr lnr-user"></span>My Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>MyAddress" ><span class="lnr lnr-map-marker"></span>My Address</a></li>
                                <li><a href="<?php echo base_url(); ?>ChangePassword" class="active"><span class="lnr lnr-lock"></span>Change Password</a></li>
                                <li><a href="<?php echo base_url(); ?>logout"><span class="lnr lnr-exit"></span>Logout</a></li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="user-inside-heading">Change Password</h4>



                                <div class="row m-0 justify-content-center">
                                    <div class="col-md-7 myprofile">
                                        <form>
                                            <div class="form-group">
                                                <label>current Password</label>
                                                <input type="password" placeholder="Enter Current Password"  class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" placeholder="Enter New Password"  class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password </label>
                                                <input type="password" placeholder="Enter Confirm Password"  class="form-control" />
                                            </div>
                                            <div class="form-group text-center">
                                                <button class="button">Update Password</button>
                                            </div>
                                        </form>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once'footer.php';?>
    </body>
</html>

