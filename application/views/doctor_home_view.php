<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($this->session->userdata['doctor_info']['id']))
{
?>

<!--<form method="POST" action="<?php echo base_url()?>doctor/log_in_validate"> 
    Email Address : <input type="text" name="email_add" id="email_add">
    Password : <input type="password" name="password" id="password">
    <input type="submit" name="submit" value="Log In">
</form>-->

<div id="admin_header"><h3 style="padding: 14px 14px;">Doctor Log-in</h3></div>
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
                    url:"<?php echo base_url()?>doctor/log_in_validate",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                        
                            //alert(msg);
                            noty({type:"notification",text:msg});
                            window.setTimeout(function(){
                                window.location = "<?php echo base_url()?>doctor/doctor_previlege/candidates";
                            }, 2000);
                        
                    }
                })
        return false;
    });
</script>

</div>
<?php //echo form_close()?>
<?php // echo validation_errors("<p class='errors'>")?>
    <?php
    }


else {
    ?>

   <!DOCTYPE html>
<body>
<!-- Beginning header -->
    
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

    
<li><img src="<?php echo base_url()?>images/icon/reserve.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="reservation_link"href="<?php echo base_url('doctor/doctor_previlege/reservation')?>">Reservations</a></li>
<li><img src="<?php echo base_url()?>images/icon/candidate.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="candidate_link"href="<?php echo base_url('doctor/doctor_previlege/candidates')?>">Today</a></li>
<li><img src="<?php echo base_url()?>images/icon/presciption.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="prescription_link"href="<?php echo base_url('doctor/doctor_previlege/prescription')?>">Prescription</a></li>
<li><img src="<?php echo base_url()?>images/icon/schedule.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="system_link"href="<?php echo base_url('doctor/doctor_previlege/system_time')?>">Time Schedule</a></li> 
<li><img src="<?php echo base_url()?>images/icon/schedule.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a id="system_link"href="<?php echo site_url('doctor/profile')?>">My Profile</a></li>
<li><img src="<?php echo base_url()?>images/icon/logout.png" title="Patient" width="20" height="20" style="position:absolute; margin: 5px 40px;"/><a href="<?php echo base_url()?>doctor/log_out">Logout</a></li>

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





<?php
}
?>