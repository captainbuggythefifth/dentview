<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>

<body>
<div id="main_container">
	<div class="header">
		
        <div id="logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>images/logo.png" title="DentView Dental Clinic" width="320" height="67" border="0" /></a></div>
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
          				<li><a href="<?php echo base_url()?>patient-reservation">Contact Us</a></li>
        			</ul>
      				</div>
    			</div>

			</div>
		</div>
      
       <div id="main_content">
    <!------------------image-------------------->
    <div>
        <?php 
        if(isset($services_with_photos))
        {
         foreach($services_with_photos as $service) 
         {
             //print_r($service);
?>
    <div class="box_content">
      <div class="box_title">
        <div class="title_icon"><img src="<?php echo base_url()?>images/checked.gif"  /></div>
        
        <h2><?php echo $service['name']?></span></h2>
      
      </div>
      <div class="box_text_content"><!-- <img src="<?php echo base_url()?>images/calendar.gif" alt="" class="box_icon" />-->
        	<div class="box_img">
                <?php
                    $str = str_ireplace(" ", "-", $service['name']);
                ?>
                <a class="fancybox-manual-<?php echo $str?>">
                
        	<img src="<?php echo $service['photo'][0]['source']?>" title="<?php echo $service['name']?>"/>	
        	</a>
                </div>
        </div>
    <!------------------description--------------------> 
      <div class="box_text_content"> <!--<img src="images/calendar.gif" alt="" class="box_icon" />-->
        <div class="box_text">
        	<?php echo $service['description']?>   	
        </div>
        <a href="#" class="details">+ details</a> </div>
    </div>
    <?php
         }
    }
    ?>
        
   <div class="clear"></div>
    
    </body>

