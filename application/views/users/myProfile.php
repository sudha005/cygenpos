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
                                <li><a href="<?php echo base_url(); ?>Userdashboard" class="active"><span class="lnr lnr-user"></span>My Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>MyAddress" ><span class="lnr lnr-map-marker"></span>My Address</a></li>
                                <li><a href="<?php echo base_url(); ?>ChangePassword" ><span class="lnr lnr-lock"></span>Change Password</a></li>
                                <li><a href="<?php echo base_url(); ?>logout"><span class="lnr lnr-exit"></span>Logout</a></li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $this->session->flashdata('error_pwd'); ?>
                                <h4 class="user-inside-heading">My Profile</h4>

                                <div class="row m-0 details-group">
                                    <!-- <div class="form-group col-md-12 text-right">-->
                                    <!--     <i class="fa fa-pencil-square-o edit-icon" aria-hidden="true"></i>-->
                                    <!--</div>-->
                                    <div class="form-group col-md-12">
                                        <label class="name-details"><?php echo $userdetails[0]->customer_name;?></label>  
                                        <span>Name</span>    
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="name-details"><?php echo $userdetails[0]->mobile;?></label>  
                                        <span>Mobile Number</span>    
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="name-details"><?php echo $userdetails[0]->email;?></label>  
                                        <span>Email Id</span>    
                                    </div>
                                </div>


                                <div class="row m-0 justify-content-center">
                                    <div class="col-md-7 myprofile">
                                        <form  action="<?php echo base_url() ?>updateProfile" method="POST">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" placeholder="Enter Name"  name="user_name" class="form-control"  value = "<?php echo $userdetails[0]->customer_name;?>" required/>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" placeholder="Enter Email"  name="user_email" class="form-control" value = "<?php echo $userdetails[0]->email;?>" required/>
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text" placeholder="Enter Mobile Number"  readonly="true" name="user_mobile" value = "<?php echo $userdetails[0]->mobile;?>" class="form-control" required/>
                                            </div>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                            <div class="form-group text-center">
                                                <button class="button" type="submit" name = "submit">Update</button>
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