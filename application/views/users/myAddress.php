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
                        <h3>My Address</h3>
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
                                <li><a href="<?php echo base_url(); ?>MyAddress" class="active"><span class="lnr lnr-map-marker"></span>My Address</a></li>
                                <li><a href="<?php echo base_url(); ?>ChangePassword" ><span class="lnr lnr-lock"></span>Change Password</a></li>
                                <li><a href="<?php echo base_url(); ?>logout"><span class="lnr lnr-exit"></span>Logout</a></li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="user-inside-heading">Manage Addresses</h4>



                                <div class="row m-0 rowmobile">
                                    <div class="col-md-6 ">
                                        <div class="myaddressbox">
                                        <h3 class="add-heading">Work</h3>
                                            <p class="myaddressp">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                            <a href="" class="edit-btn">Edit</a>&nbsp;&nbsp; <a href="" class="delete-btn">Delete</a>
                                        </div>
                                    </div>
                                     <div class="col-md-6 ">
                                        <div class="myaddressbox">
                                        <h3 class="add-heading">Home</h3>
                                            <p class="myaddressp">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                            <a href="" class="edit-btn">Edit</a>&nbsp;&nbsp; <a href="" class="delete-btn">Delete</a>
                                        </div>
                                    </div>
                                     <div class="col-md-6 ">
                                        <div class="myaddressbox">
                                        <h3 class="add-heading">Other</h3>
                                            <p class="myaddressp">326/336 Great Western Hwy, Wentworthville NSW 2145</p>
                                            <a href="" class="edit-btn">Edit</a>&nbsp;&nbsp; <a href="" class="delete-btn">Delete</a>
                                        </div>
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