<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<body>
<div id="main_container">
	<div class="header">
		
        <div id="logo">
        	<a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>images/logo.png" title="DentView Dental Clinic" width="320" height="67" border="0" alt="DentView Dental Clinic"/></a></div>
        
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
          				<li><a class="current" href="<?php echo base_url()?>">Home</a></li>
                                        <li><a href="<?php echo base_url()?>patient-view-all-doctors">Doctors</a></li>
                                        <li><a href="<?php echo base_url()?>patient-services">Services</a></li>
          				<li><a href="<?php echo base_url()?>patient-lapay">Contact Us</a></li>
        			</ul>
      				</div>
    			

			</div>
		</div>
        <div id="middle_box2">
            <center>
                Please do visit your email address. We sent you a message of confirming your email account.
            </center>
        </div>