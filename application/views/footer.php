<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b><?php  echo $SITE_TITLE;?> -v<?= $VERSION;?></b> 
    </div>
    <strong>Copyright &copy; <?=date("Y")?> All rights reserved.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
        
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
   <audio id="buzzer">
      <source src="<?php echo base_url(); ?>assets/audio/pristine.mp3" type="audio/mp3">
      Your browser does not support the audio element.
    </audio>
    <audio id="buzzer2">
      <source src="<?php echo base_url(); ?>assets/audio/juntos.mp3" type="audio/mp3">
      Your browser does not support the audio element.
    </audio>
    <audio id="buzzer3">
      <source src="<?php echo base_url(); ?>assets/audio/filling-your-inbox.mp3" type="audio/mp3">
      Your browser does not support the audio element.
    </audio>
    <?php 
    $CI = & get_instance();
    ?> 
        
   <input type="hidden" id="base_urlad" value="<?php echo base_url(); ?>">
  
<script>
$(document).ready(function(){
  
  //  setInterval(function(){
  //      console.log("3second");
  //         var formData ={'<?php echo $CI->security->get_csrf_token_name(); ?>' : '<?php echo $CI->security->get_csrf_hash(); ?>'}; //Array 
  //         $.ajax({
  //          type: "POST",
  //            url :$("#base_urlad").val()+"Home/count_neworder_instore",
  //          data: formData,
  //          success: function (response) {
  //           //   console.log(response);
  //           var response_data =  response.split("~");
  //           $(".pushval3").html(response_data['0']);
  //            if (response_data['0'] > 0){
  //              $('#buzzer').trigger('play');
                   
                 
  //               swal({
  //         title: "New  Table Top Order    ",
  //         text: response_data['1'],
  //         icon: "success",
  //         buttons: [
  //           'No, cancel it!',
  //           'Print Order'
  //         ],
  //         dangerMode: true,
  //       }).then(function(isConfirm) {
  //         if (isConfirm) {
  //           var saleid=response_data['2'];  
  //          window.open("<?= base_url();?>pos/print_invoice_pos/"+saleid, "_blank", "scrollbars=1,resizable=1,height=500,width=500"); 
  //          swal.close(); 
  //         } 
  //       });
   
  //            } else {
  //                $('#buzzer').trigger('pause');
  //                swal.close(); 
  //            }
  //          }
  //          });
       
  // },5000);
       
});
</script>
<script type="text/javascript">
  function print_invoice(id){
  window.open("<?= base_url();?>pos/print_invoice_pos/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}
  function print_kot_pos(id){
  window.open("<?= base_url();?>pos/print_kot_pos/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}
</script>
<script>
  function initFreshChat() {
      
    window.fcWidget.init({
      token: "7c7b9bbb-d1fe-4af9-ab33-f54144b21c3f",
      host: "https://wchat.au.freshchat.com"
    });
    
    // To set unique user id in your system when it is available
window.fcWidget.setExternalId("Cygenpos");
    // To set user name
window.fcWidget.user.setFirstName("Cygen");

// To set user email
window.fcWidget.user.setEmail("info@cygenpos.com.au");

// To set user properties
window.fcWidget.user.setProperties({
  plan: "Estate",                 // meta property 1
  status: "Active"                // meta property 2
});
    
  }
  function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src="https://wchat.au.freshchat.com/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}function initiateCall(){initialize(document,"freshchat-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
</script>