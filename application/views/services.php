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
          				<li><a id="current" href="<?php echo base_url()?>">Home</a></li>
                                        <li><a id="patient-view-all-doctors" href="<?php echo base_url()?>patient-view-all-doctors">Doctors</a></li>
                                        <li><a id="patient-services"style="color:#68C2EF; margin:-5px 0;" href="<?php echo base_url()?>patient-services">Services</a></li>
          				<li><a href="#div_contact_us" id="contact_us">Contact Us</a></li>
                                        <li><a id="patient-services" href="<?php echo base_url()?>faq">F.A.Q</a></li>
        			</ul>
      				</div>
    			</div>

			</div>
		</div>
      
       <div id="middle_box2">
       <div style="padding: 0 18px;">
    
    <!------------------image-------------------->
    <br><div class="img_top"></div>
    <div class="title"><h1>Services</h1></div>   
    <div class="img_bottom"></div>
    
    <div>
        
        <?php if(isset($pages))
                {
                    $uri_string = $this->uri->segment(2);
                    
                    echo "<div id='pages' align='center' style='padding-top:10px;'>";
                    if($uri_string != '1')
                    {
                        ?>
                        <a class='page' href="<?php echo base_url()."patient-services/".($uri_string-1)?>"><<</a>
                        <?php
                    }
                    for($i=1;$i<=$pages;$i++)
                    {
                    ?>
                        <a class='page' href="<?php echo base_url()?>patient-services/<?php echo $i?>"><?php echo $i?></a>
                        <?php
                    }
                    if($uri_string != $pages)
                    {
                        ?>
                        <a class='page' href="<?php echo base_url()."patient-services/".($uri_string+1)?>">>></a>
                        <?php
                    }
                    echo "";
                }
            ?>
        </div>
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
      <div class="box_text_content2" align="center">
        	<div class="box_img2" align="center">
                <?php
                    $str = str_ireplace(" ", "-", $service['name']);
                ?>
                <a class="fancybox-manual-<?php echo $str?>">
                
        	<img src="<?php echo base_url().$service['photo'][0]['source']?>" title="<?php echo $service['name']?>"/>	
        	</a>
                </div>
        </div>
    <!------------------description--------------------> 
      <div class="box_text_content"> 
        <div class="box_text">
            <?php
        	if(strlen($service['description']) > 20)
                {
                    $desc = $service['description'];
                    $str = "";
                    for($i=0;$i<20;$i++)
                    {
                        $str = $str.$desc[$i];
                    }
                    echo "Description : ".$str."...";
                }
                else
                {
                    echo "Description : ".$service['description'];
                }
            ?>
        </div>
        <div class="fancybox-manual-<?php echo $str?>"><a href="#" class="details">+ view photos</a> </div>
        
    </div>
    </div>
    <?php
         }
    }
    ?>
        
        
        </div>
    </div>
   <div class="clear"></div>
   
    
    </body>
    
    
    
    

