<?php

if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
$link_for_reserve = '#link_for_reserve';
if (isset($this->session->userdata['patient_info']['id'])) {
    //$link_for_reserve = base_url().'patient-reservation';
    $link_for_reserve = '#link_load_reservation';
}

if (isset($is_edited) && $is_edited == true) {
    echo "<script> alert('Your profile has been successfully updated!'); </script>";
    $is_edited = false;
}
if (isset($msg)) {
    echo $msg;
    //print_r($patient_info);
}

if (isset($this->session->userdata['patient_info']['reservation_info'])) {
    $reservation_info = $this->session->userdata['patient_info']['reservation_info'];
    if (count($reservation_info) > 0) {
        $is_reserve_or_reschedule = "RESCHEDULE";
    } else {
        $is_reserve_or_reschedule = "RESERVE";
    }
}

if (isset($doctor_info) && isset($photo_info)) {
    
}
?>

<body>
    <div id="main_container">
        <div class="header">

            <div id="logo">
                <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>images/logo.png" title="DentView Dental Clinic" width="320" height="67" border="0" alt="DentView Dental Clinic"/></a></div>

            <div class="right_header">
                <div class="top_menu">
<?php
if (!isset($this->session->userdata['patient_info']['id'])) {
    ?>
                        <a id="fancybox_log_in" class="login" href="#log_in" title="Log in">login</a> 
                        <a id="fancybox_sign_up" class="sign_up" href="#sign_up" title="Sign up">signup</a> 
    <?php
} else {
    ?>
                        <a id="fancybox_log_in" class="login" href="<?php echo base_url() ?>patient-profile" title="My profile">profile</a> 
                        <a id="fancybox_sign_up" class="sign_up" href="<?php echo base_url() ?>patient-log-out" title="Log out">log out</a> 
                        <?php
                    }
                    ?>
                </div>
                <div id="menu">
                    <ul>
                        <li><a id="current" href="<?php echo base_url() ?>">Home</a></li>
                        <li><a style="color:#68C2EF; margin: -5px 0;" href="<?php echo base_url() ?>patient-view-all-doctors">Doctors</a></li>
                        <li><a href="<?php echo base_url() ?>patient-services">Services</a></li>
                        <li><a href="<?php echo base_url() ?>patient-lapay">Contact Us</a></li>
                        <li><a id="patient-services" href="<?php echo base_url()?>faq">F.A.Q</a></li>
                    </ul>
                </div>


            </div>
        </div>
        <div id="middle_box2">
            <div class="left_box">
                <div id="profile" align="center">
                    <div class="prof_pic" style="background:url(<?php echo base_url().$photo_info['source']; ?>)no-repeat center;">

                    </div>
                </div>
                <h1 align="center" style="color: #759f1b; margin: 10px 0 -35px 0"><?php echo "Dr. " . $doctor_info['first_name'] . " " . $doctor_info['mi'] . " " . $doctor_info['last_name']; ?></h1>
                <div class="box">
                    <div class="menu">
                    <ul>
                        <li><img src="<?php echo base_url()?>/images/icon/user.png">Name: <a href="#"><?php echo $doctor_info['first_name'] . " " . $doctor_info['mi'] . " " . $doctor_info['last_name']; ?></a></li>
                        <li><img src="<?php echo base_url()?>/images/icon/age.png">Age: <a href="#">22</a></li>
                        <li><img src="<?php echo base_url()?>/images/icon/address.png">Address: <a href="#"><?php echo $doctor_info['address'] ?></a></li>
                        <li><img src="<?php echo base_url()?>/images/icon/contact.png">Contact: <a href="#"><?php echo $doctor_info['email_add'] ?></a></li>

                    </ul>
                    </div>
                </div>
                
                <div class="box">
                    <div class="menu">
                    <ul>
                        <li><img src="<?php echo base_url()?>/images/icon/contact.png"><a href="#div_personal_message" id="fancybox_personal_message" name="<?php echo $doctor_info['id'] ?>">Message</a></li>
                    </ul>
                    </div>
                </div>
                

            </div>
            <div class="right_box">

                <div class="table" style="height:500">




         <!-- <input type="text" id="date"> -->


                    <div id="tabs" style="height:493">
                        <ul>

                            <li><a href="#expertise" id="">Expertise</a></li>

                        </ul>


                        <div id="expertise">
                            <?php
                            if (isset($expertise_with_service)) {
                                foreach ($expertise_with_service as $expert) {
                                    if(is_array($expert) && count($expert) > 0)
                                    {
                                        echo "<b>" . $expert['name'] . "</b>: " . $expert['description'] . "</br>";
                                    }
                                
                                }
                            }
                            ?>
                        </div>
                    </div>


                </div>

            </div>
            
            
            
            </body>
            
            
            <script>
        $('#button_contact_us').click(function(){
            var form_data = {
                patient_id : "<?php echo $this->session->userdata['patient_info']['id']?>",
                query : $('#query').val(),
                about : $('#about').val()
            }
            
            $.ajax({
                url : "<?php echo base_url()?>patient/send_query",
                type : "POST",
                data : form_data,
                success : function(msg){
                    noty({type:"notification",text:msg});
                }
            })
        })
    </script>
    
    <div id="div_personal_message" style="display:none">
        <?php if(isset($this->session->userdata['patient_info']['id']))
        {
        ?>
            <input type="hidden" id="to_id" value="<?php echo $doctor_info['id']?>">
            To : Dr. <?php echo $doctor_info['first_name'].' '.$doctor_info['last_name']?></br>
            Message : <textarea rows="5" cols="10" id="message"></textarea>
            <input type="button" value="Send" id="button_send">
        <?php 
        }
        else
        {
        ?>
            Please do log in first to further continue on this service.
        <?php  
        }
        ?>
    </div>

    

