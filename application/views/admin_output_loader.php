<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html>
<body>
<!-- Beginning header -->
    <?php
    if(!isset($this->session->userdata['admin_info']['id']))
    {
    //echo form_open('admin-log-in-validate'); ?>

<div id="admin_header"><h3 style="padding: 14px 14px;">Admin Log-in</h3></div>
<div id="admin_login">
<div style="margin-bottom:15px;">Email Address: <span class="admin_eml"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="email_add"
                       id ="email_add_log_in_admin"
                       class="admin_eml"
                       value =""/></span>
                <br/></div>

<div>Password:<span class="admin_pswd"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="password"
                       name ="password"
                       id ="password_log_in_admin"
                       class="admin_pswd"
                       value =""/></span>
                        </div>
</div>
<div id="admin_footer">	<input type="submit"
                       	name="submit"
                       	id="admin_submit"
                        class="admin_btn"
                       	value ="Log in"/>
    
    <script>
    $('#admin_submit').click(function(){
        var form_data = {
            email_add : $('#email_add_log_in_admin').val(),
            password : $('#password_log_in_admin').val()
        };
        $.ajax({
                    url:"<?php echo base_url();?>admin/log_in_validate",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                        if(msg == 1)
                        {
                            noty({type:"notification",text:"Password did not match"});
                            
                        }
                        else
                        {
                            //alert(msg);
                            noty({type:"notification",text:msg});
                            window.setTimeout(function(){
                                window.location = "<?php echo base_url()?>index.php/administer/candidates";
                            }, 2000);
                        }
                    }
                })
        return false;
    });
</script>
<script language="JavaScript">
<!--
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}
//-->
</script>
</div>
<?php //echo form_close()?>
<?php // echo validation_errors("<p class='errors'>")?>
    <?php
    }
        if(isset($this->session->userdata['admin_info']['id']))
        {
            //
           ?>
        <script type="text/javascript">
var suwat=["suwat1", "suwat2", "suwat3"]
function filltext(words){
for (var i=0; i<words; i++)
document.write(suwat[Math.floor(Math.random()*3)]+" ")
}
</script>




<div id="header_bg">
<div id="logo">
    <a href="<?php echo base_url()?>administer/candidates"><img src="<?php echo base_url()?>css/admin_css/logo.png" title="DentView Dental Clinic" width="320" height="64" border="0" alt="DentView Dental Clinic"/></a></div>
</div>
<div class="navbox">
<ul class="nav">
    <?php if(isset($this->session->userdata['doctor_info']['id']))
    {
        if(isset($this->session->userdata['doctor_info']['notification_info']))
        {
            $ctr = 0;
            $last_id = "";
            foreach($this->session->userdata['doctor_info']['notification_info'] as $notification)
            {
                if($notification['status'] == "ACTIVE")
                {
                    $ctr++;
                    $last_id = $notification['id'];
                }
            }
        }
        ?>
    
    <li><img src="<?php echo base_url()?>images/icon/doctor.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="fancybox_doctor_notification" name="<?php if(isset($last_id)) echo $last_id ?>" href="#my_notification">Notifications(<?php if(isset($ctr)) echo $ctr;?>)</a></li>   
    <?php }
        
    ?>
<li><img src="<?php echo base_url()?>images/icon/patient.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="patient_link" href="<?php echo site_url('administer/patient')?>">Patients</a></li>
<li><img src="<?php echo base_url()?>images/icon/admin.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="admin_link"href="<?php echo site_url('administer/admin')?>">Administrator</a></li>
<li><img src="<?php echo base_url()?>images/icon/doctor.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="doctor_link"href="<?php echo site_url('administer/doctor')?>">Doctors</a></li>
<li><img src="<?php echo base_url()?>images/icon/reserve.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="reservation_link"href="<?php echo site_url('administer/reservation')?>">Reservations</a></li>
<li><img src="<?php echo base_url()?>images/icon/services.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="service_link"href="<?php echo site_url('administer/service')?>">Services</a></li>
<li><img src="<?php echo base_url()?>images/icon/upload.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="upload_link"href="<?php echo base_url()?>admin/upload/service/1">Upload</a></li>
<li><img src="<?php echo base_url()?>images/icon/candidate.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="candidate_link"href="<?php echo site_url('administer/candidates')?>">Today</a></li>
<li><img src="<?php echo base_url()?>images/icon/presciption.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="prescription_link"href="<?php echo site_url('administer/prescription')?>">Prescription</a></li>
<li><img src="<?php echo base_url()?>images/icon/schedule.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="system_link"href="<?php echo site_url('administer/system_time')?>">Time Schedule</a></li>
<li><img src="<?php echo base_url()?>images/icon/customer.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="customer_care_link"href="<?php echo site_url('administer/customer_care')?>">Customer Care</a></li>
<li><img src="<?php echo base_url()?>images/icon/help.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="faq_link" href="<?php echo site_url('administer/faq')?>">F.A.Q</a></li>
<li><img src="<?php echo base_url()?>images/icon/help.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="secretary_link" href="<?php echo site_url('administer/secretary')?>">Secretaries</a></li>
<li><img src="<?php echo base_url()?>images/icon/logout.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a href="<?php echo base_url()?>administer-log-out">Logout</a></li>

</ul>
<div style="border: 1px solid #ccc; border-top:none; height:500px; width:196px; background:#F0F0F0;"></div>
</div>

<div id="my_notification" style="display: none; height: auto">
        <?php /* if(isset($notification_about_personal_message_info))
                //{
                
                //if(is_array($notification_about_personal_message_info) && count($notification_about_personal_message_info) > 0)
               // {
                    $i = 0;
                    $count = count($notification_about_personal_message_info);
                   
                 ?>
                
                Personal Message
                <div style="border: solid 1px #000">
                    <input type="hidden" id="to_id">
                <?php
                    foreach($notification_about_personal_message_info as $notification)
                    {
                        print_r($notification);
                        
                        
                        
                    }
                    ?>
                    </div>
                    <?php
                }
                else
                {
                ?>
                    You have no reply yet.</br>
                    <?php
                }
                }
                */
        
                if(isset($this->session->userdata['doctor_info']['notification_info']))
                {
                    $notification_about_reservation_info = $this->session->userdata['doctor_info']['notification_info'];
                    if(is_array($notification_about_reservation_info) && count($notification_about_reservation_info) > 0)
                    {
                        
                ?>
                <div class="bg_table" style="padding:20px">
                My Reservation
                <div style="border: solid 1px #CCC; padding:10px; background: #fff;">
                <?php
                    foreach($notification_about_reservation_info as $notification)
                    {
                        
                        if($notification['status'] == "INACTIVE")
                        {
                        ?>
                            <div style=" border: 1px solid #0C0; background: #cfc;">
                        <?php
                        }
                        else
                        { ?>
                            <div style=" border: 1px solid #F90; background: #ffc;">
                        <?php
                        }
                        ?>
                            Date : <?php echo date("F d Y",  strtotime($notification['date']))?></br>
                            Message : <?php echo $notification['msg']?></br>
                            
                        </div>
                        <?php
                    }
                ?>
                    </div>
                    <?php
                    }
                    else
                    {
                        ?>
                        You have no record yet.</br>
                        <?php
                    }
                
                }
            ?>
                        </div>
    </div>
    </div>
<div id="maincontent">
<div class="innertube">

        

<!-- End of header-->
    
      



<?php
        }
       
        ?>


<!-- Beginning footer -->

<!-- End of Footer -->
<script>
        $('#fancybox_doctor_notification').click(function(){
            var form_data = {
                notification_id : this.name
            }
            
            $.ajax({
                url : "<?php echo base_url()?>patient/notification_update",
                type : "POST",
                data : form_data,
                success : function(msg){
                }
            })
        })
    </script>




