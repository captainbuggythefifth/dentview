<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
    $link_for_reserve = '#link_for_reserve';
    if(isset($this->session->userdata['patient_info']['id']))
    {
        //$link_for_reserve = base_url().'patient-reservation';
        $link_for_reserve = '#link_load_reservation';
    }
    
    if(isset($is_edited) && $is_edited == true)
    {
        echo "<script> alert('Your profile has been successfully updated!'); </script>";
        $is_edited = false;
    }
    if(isset($msg))
    {
        echo $msg;
    //print_r($patient_info);
    }
    
    if(isset($this->session->userdata['patient_info']['reservation_info']))
    {
        $reservation_info = $this->session->userdata['patient_info']['reservation_info'];
        if(count($reservation_info) > 0)
        {
            $is_reserve_or_reschedule = "RESCHEDULE";
        }
        else
        {
            $is_reserve_or_reschedule = "RESERVE";
        }
    }
    
    if(isset($doctor_info) && isset($photo_info))
    {
        
    }
?>

<body>
<div id="main_container">
	<div class="header">
		
        <div id="logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>images/logo.png" title="DentView Dental Clinic" width="320" height="64" border="0" /></a></div>
    		<div class="right_header">
      			<div class="top_menu">
                            <?php if(!isset($this->session->userdata['patient_info']['id']))
                                    {
                             ?>
                                    <a id="fancybox_log_in" class="login" href="#log_in" title="Log in">login</a> 
                                    <a id="fancybox_sign_up" class="sign_up" href="#sign_up" title="Sign up">signup</a> 
                            <?php 
                                    }
                                    else
                                    {
                                        
                            ?>
                                    <a id="fancybox_log_in" class="login" href="<?php echo base_url()?>patient-profile" title="My profile">profile</a> 
                                    <a id="fancybox_sign_up" class="sign_up" href="<?php echo base_url()?>patient-log-out" title="Log out">log out</a> 
                            <?php
                                    }
                            ?>
                        </div>
      				<div id="menu">
        			<ul>
          				<li><a id="current" href="<?php echo base_url()?>">Home</a></li>
                                        <li><a id="patient-view-all-doctors" style="color:#68C2EF; margin: -5px 0;" href="<?php echo base_url()?>patient-view-all-doctors">Doctors</a></li>
                                        <li><a id="patient-services" href="<?php echo base_url()?>patient-services">Services</a></li>
                                        <li><a href="#div_contact_us" id="contact_us">Contact Us</a></li>
                                        <li><a id="patient-services" href="<?php echo base_url()?>faq">F.A.Q</a></li>
        			</ul>
      				</div>
    			</div>

			</div>
		</div>
      
      
      
		
       <div id="middle_box2"><br>
           <div style="width:880px; float:right;">
                <div class="img_top"></div>
                <div class="title"><h1>Doctors</h1></div>   
                <div class="img_bottom"></div><br>
                    
                    
                    <?php
                        if(isset($complete_info_from_doctor))
                        {
                            foreach($complete_info_from_doctor as $doctor)
                            {
                      ?>
                      <div class="doc_bg">
                        <div id="div_doctor_info">
                        
                            <div class="doctor_pic" align="center">
                                <img src="<?php echo base_url().$doctor['photo_info']['source']?>" style="width: 200px; height: 200px;"></div>
                            <div class="doctor_name">
                            	<span class="d_name">Name: <a href="<?php echo base_url()?>patient-view-doctor-profile/<?php echo $doctor['doctor_info']['id']?>"><?php echo $doctor['doctor_info']['first_name']." ".$doctor['doctor_info']['last_name']?></a></span></div>
                            <div class="doctor_discription">
                            	<span class="d_name"><br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </span></div>
                        </div>
                      </div>
                    <br>
                        
                    <?php
                            }
                        }
                    ?>
                    </div>

    </body>
    
    