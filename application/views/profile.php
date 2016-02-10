<script>
    var interval;
    $(window).ready(function(){
<?php
if ($_GET['msg'] == "ufe") {
    ?>
                        $.fancybox('#profile_photo');
    <?php
}
?>
                });
</script>
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$link_for_reserve = '#link_for_reserve';
if (isset($this->session->userdata['patient_info']['id'])) {
    //$link_for_reserve = base_url().'patient-reservation';
    $link_for_reserve = '#link_load_reservation';
}



if (isset($this->session->userdata['patient_info']['reservation_info'])) {
    $reservation_info = $this->session->userdata['patient_info']['reservation_info'];
    if (count($reservation_info) > 0) {
        $is_reserve_or_reschedule = "Reschedule";
    } else {
        $is_reserve_or_reschedule = "Reserve";
    }
} elseif (!isset($this->session->userdata['patient_info']['reservation_info'])) {
    $is_reserve_or_reschedule = "Reserve";
}

if (isset($notification_about_reservation_info)) {
    if (is_array($notification_about_reservation_info) && count($notification_about_reservation_info) > 0) {
        $last_id = "";
        foreach ($notification_about_reservation_info as $notification_new) {
            if ($notification_new['status'] == "ACTIVE") {
                $last_id = $notification_new['id'];
            }
        }
    } else {
        $notification_about_reservation_info = false;
        $last_id = "";
    }
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
                        <li><a id="patient-view-all-doctors" href="<?php echo base_url() ?>patient-view-all-doctors">Doctors</a></li>
                        <li><a id="patient-services" href="<?php echo base_url() ?>patient-services">Services</a></li>
                        <li><a href="#div_contact_us" id="contact_us">Contact Us</a></li>
                        <li><a id="patient-services" href="<?php echo base_url() ?>faq">F.A.Q</a></li>
                    </ul>
                </div>


            </div>
        </div>
        <div id="middle_box2">
            <div class="left_box">
                <div id="profile" align="center">
                    <div class="prof_pic" style="background:url(<?php echo base_url() . $this->session->userdata['patient_info']['photo_info']['source']; ?>)no-repeat center;" title="My Profile Picture" name="<?php echo $this->session->userdata['patient_info']['photo_info']['name'] ?>"> <div id="change_picture" style="display:none; background-color: black; opacity: 0.75; border-top: 100"><?php echo $this->session->userdata['patient_info']['photo_info']['name'] ?></div>
                    </div>
                </div>
                <h1 align="center" style=" color: #759f1b; margin: 10px 0 -35px 0;"><?php echo $this->session->userdata['patient_info']['first_name'] . " " . $this->session->userdata['patient_info']['mi'] . " " . $this->session->userdata['patient_info']['last_name']; ?></h1>
                <div class="box">
                    <div id="history" class="btn_menu">
                        <div class="btn_list"  align="center">
                            <ul>
                                <li><a class="fancybox" href="#inline1" title="Profile Edit">Edit Profile</a></li>
                                <li><a class="fancybox" href="#profile_photo" title="Change profile photo">Upload Photo</a></li>
                                <li><a href="#my_history" class="fancybox_history" name="<?php echo $this->session->userdata['patient_info']['id'] ?>">My History</a></li>
                                <li><a href="#my_history" class="fancybox_tooth_history" name="<?php echo $this->session->userdata['patient_info']['id'] ?>">My Tooth</a></li>
                                <li><a href="#my_notification" class="fancybox_notification" name="<?php echo $last_id ?>">My Notification(<?php
                    $ctr = 0;
                    if (isset($notification_about_reservation_info)) {
                        if (is_array($notification_about_reservation_info) && count($notification_about_reservation_info) > 0) {
                            foreach ($notification_about_reservation_info as $notification) {
                                if ($notification['status'] == "ACTIVE") {
                                    $ctr++;
                                }
                            }
                        } else {
                            $ctr = 0;
                        }
                    }
                    echo $ctr;
?>)</a></li></ul>

                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="menu">
                        <ul>
                            <li><img src="<?php echo base_url() ?>images/icon/user2.png">Name: <a href="#"><?php echo $this->session->userdata['patient_info']['first_name'] . " " . $this->session->userdata['patient_info']['mi'] . " " . $this->session->userdata['patient_info']['last_name']; ?></a></li>
                            <li><img src="<?php echo base_url() ?>images/icon/contact2.png">Mobile Number: <a href="#"><?php echo $this->session->userdata['patient_info']['mobile_number'] ?></a></li>
                            <li><img src="<?php echo base_url() ?>images/icon/address.png">Address: <a href="#"><?php echo $this->session->userdata['patient_info']['address'] ?></a></li>
                            <li><img src="<?php echo base_url() ?>images/icon/age.png">Age: <a href="#"><?php echo $this->session->userdata['patient_info']['age'] ?></a></li>
                            <!--<li><img src="<?php echo base_url() ?>/images/icon/address.png">Gender: <a href="#"><?php echo $this->session->userdata['patient_info']['gender'] ?></a></li>
                            <li><img src="<?php echo base_url() ?>/images/icon/address.png">Status: <a href="#"><?php echo $this->session->userdata['patient_info']['marital_status'] ?></a></li>
                            <li><img src="<?php echo base_url() ?>/images/icon/address.png">Occupation: <a href="#"><?php echo $this->session->userdata['patient_info']['occupation'] ?></a></li>
                            -->
                            <li><img src="<?php echo base_url() ?>images/icon/msg.png">Contact:
                                <a href="#" title="<?php echo $this->session->userdata['patient_info']['email_add'] ?>">
                                        <?php
                                        $email_add_length = strlen($this->session->userdata['patient_info']['email_add']);
                                        if ($email_add_length > 15) {
                                            $temp = $this->session->userdata['patient_info']['email_add'];
                                            $email_add = "";

                                            for ($i = 0;; $i++) {
                                                if ($temp[$i] == "@") {
                                                    break;
                                                }
                                                $email_add = $email_add . $temp[$i];
                                            }

                                            echo $email_add . "...";
                                        } else {
                                            echo $this->session->userdata['patient_info']['email_add'];
                                        }
                                        ?>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>


            </div>
            
            <div class="right_box">

                <div class="table" style="height:600">




         <!-- <input type="text" id="date"> -->
                    <div id="tabs" style="height:600; width:450px;" >
                        <ul>
                                    <?php
                                    if (isset($this->session->userdata['patient_info']['reservation_info'])) {
                                        $reservation_info = $this->session->userdata['patient_info']['reservation_info'];
                                        if (count($reservation_info) > 0) {
                                            //print_r($reservation_info);
                                            ?>
                                    <li><a style="cursor: pointer" href="#my_schedule">My Schedule</a></li>
                                        <?php }
                                    }
                                    ?>
                            <li><a style="cursor: pointer" href="#link_load_reservation" id="click_to_load"><?php echo $is_reserve_or_reschedule; ?></a></li>

                        </ul>

                        <div id="reservation_div">
                            <input type="hidden" id="input_hidden_previous_reservation_data" value="0">
                            <div id="link_load_reservation">
                                <!-- <div id="click_to_load"><center><h3><?php echo $is_reserve_or_reschedule; ?></h3></center></div> -->
                                <div id="img_loader" style="display: none;"> 
                                    <img src="<?php base_url() ?>images/loading.gif" style="height: 20;width: 20"> 
                                </div>
                                <div id="loader"> </div>
                                <div id="form_reschedule" style="display:none">

<?php
if (count($doctors) > 0) {

    if (count($doctors) == 1) {
        ?>
                                            <span style="font-weight:bold;">Doctor Assigned:</span> <?php echo $doctors[0]['first_name'] . " " . $doctors[0]['last_name'] ?>   <input id="doctor_id" type="hidden" value="<?php echo $doctors[0]['id'] ?>" name="doctor_id">
                                    <?php
                                } else {
                                    ?>

                                            <div align="left" style="width: 100">
                                            <span style="font-weight:bold;">
                                                Date:
                                            </span>
                                    <input type="text" id="date_reserve" value="<?php
                                    if (isset($this->session->userdata['patient_info']['reservation_info']['id'])) {

                                        echo date("m/d/Y", strtotime($this->session->userdata['patient_info']['reservation_info']['date']));
                                    }
                                    ?>"/>
                                                <div id="div_doctor_loader" style="width: 100">  
                                                Select Doctor: <select id="doctor_id" name="doctor_id" title="Click me to Select Doctor">
                                    <?php foreach ($doctors as $doctor) { ?>
                                                        <option value="<?php echo $doctor['id'] ?>" <?php
                            if (isset($this->session->userdata['patient_info']['reservation_info']['id'])) {
                                if ($doctor['id'] == $this->session->userdata['patient_info']['reservation_info']['doctor_id']) {
                                    echo "selected";
                                }
                            }
                            ?>>
            <?php echo $doctor['first_name'] . " " . $doctor['last_name'] ?>
                                                        </option>
        <?php } ?>      
                                                </select>

        <?php
    }
} else {
    ?>

                                            Doctor Assigned: Joel Taytayan   <input type="hidden" value="0" name="doctor_id" id="doctor_id">

                                        <?php
                                    }
                                    ?>
                                    
                                    Not available? Please specify: <input type="text" id="specified_service" value="<?php
                                    if (isset($this->session->userdata['patient_info']['reservation_info']['id'])) {

                                        echo $this->session->userdata['patient_info']['reservation_info']['specified_service'];
                                    }
                                    ?>">
                                    <div align="left" id="doctor_expertise" style="width:300"></div>


                                    </div>
                                    </div>
                                    <input type="hidden" id="time" value="<?php
                                            if (isset($this->session->userdata['patient_info']['reservation_info']['id'])) {

                                                echo $this->session->userdata['patient_info']['reservation_info']['time'];
                                            }
                                    ?>"/>

                                    <div id="time_available" align="center"> </div>
                                    <div id="time_reservation"> </div>
                                    <div id="success"> </div>

                                </div>
                            </div>
                            
<?php
if (isset($this->session->userdata['patient_info']['reservation_info'])) {
    $reservation_info = $this->session->userdata['patient_info']['reservation_info'];
    if (count($reservation_info) > 0) {
        //print_r($reservation_info);
        ?>
                                
                                    <div id="my_schedule">
                                        <input type="hidden" id="reservation_id" value="<?php echo $reservation_info['id']; ?>">
                                        <h2>My Schedule: </h2></br>
                                           
                                            <div style="margin-bottom:3px;"><span style="font-weight:bold;">Time:</span>
                                            <span style="margin-left:18px; padding-left:2px;"><?php
                                            $time = $reservation_info['time'][0] . $reservation_info['time'][1];
                                            if ($time <= 11) {
                                                echo $time . ":00 AM";
                                            } elseif ($time == 12) {
                                                echo $time . ":00 PM";
                                            } else {
                                                echo ($time - 12) . ":00 PM";
                                            }
                                            ?></span></div>
                                            <div style="margin-bottom:3px;"><span style="font-weight:bold;">Date:</span>
                                            <span style="margin-left:22px; padding-left:2px;"><?php
                                            $date = new DateTime($reservation_info['date']);
                                            echo date_format($date, "F d, Y") . '</br>';
                                        }
                                        if ($this->session->userdata['patient_info']['doctor_info']) {
                                            $doctor_assigned = $this->session->userdata['patient_info']['doctor_info'];
                                            //echo "Doctor Assigned: ".$doctor_assigned['first_name']." ".$doctor_assigned['last_name'];
                                            ?></span></div>
                                            <span style="font-weight:bold;">Doctor Assigned:</span> <span style="margin-left:12px; padding-left:2px;"><a class="d_link" href="<?php echo base_url() ?>patient-view-doctor-profile/<?php echo $doctor_assigned['id'] ?>"> <?php echo "Dr. " . $doctor_assigned['first_name'] . " " . $doctor_assigned['last_name']; ?> </a>&nbsp;&nbsp;
                                            <a class="d_link" href="#" id="cancel_reservation" name="<?php echo $reservation_info['id'] ?>">Cancel Reservation</a></span>
                                        
                                    </div>
        <?php
    }
}
?>

                        </div>
                    </div>
                    
                
                <div id="btn">
                    <div class="resched">
                        <ul>
                            <li><a id="reserve_or_reschedule" class="rsrv_btn" href="#"><?php echo $is_reserve_or_reschedule; ?></a></li>
                        </ul>
                    </div>

                </div>

            </div>
    

            <div id="my_history" style="display:none; width: 430px; height: 600"></div>
            <div id="inline1" class="edit_prof" style="width:300px; height:350px;">
                <h3 style="color:#036">EDITING MY PROFILE</h3>
                <div id='forms' class="edit_form">
                                    <?php
                                    if (isset($msg)) {
                                        echo $msg;
                                        unset($msg);
                                    }
                                    ?>
                                    <?php //echo form_open('patient/profile_edit');  ?>
                                    <?php
                                    $pass = ($this->session->userdata['patient_info']['password']);
                                    $patient = array(
                                        'first_name' => 'first_name',
                                        'mi' => 'mi',
                                        'last_name' => 'last_name',
                                        'mobile_number' => 'mobile_number',
                                        'email_add' => 'email_add',
                                        'password' => 'password',
                                        'address' => 'address'
                                    );
                                    ?>


                    <span style="color:#036">First Name:</span> <span class="fname"><input type='text' id="first_name" class="fname" name='first_name' value='<?php echo $this->session->userdata['patient_info']['first_name'] ?>'></span> </br>
                    <span style="color:#036">Middle Initial:</span> <span class="mi"><input type='text' id="mi" class="mi" name='mi' value='<?php echo $this->session->userdata['patient_info']['mi'] ?>'></span> </br>
                    <span style="color:#036">Last Name:</span> <span class="lname"><input type='text' id="last_name" class="lname" name='last_name'value='<?php echo $this->session->userdata['patient_info']['last_name'] ?>'></span> </br>
                    <span style="color:#036">Mobile Number:</span> <span class="mobile"><input type='text' id="mobile_number" class="mobile" name='mobile_number' value='<?php echo $this->session->userdata['patient_info']['mobile_number'] ?>'></span> </br>
                    <span style="color:#036">Email Address:</span> <span class="eml_add"><input type='text' id="email_add" class="eml_add" name='email_add' value='<?php echo $this->session->userdata['patient_info']['email_add'] ?>'></span> </br>
                    <span style="color:#036">Address:</span> <span class="addrss"><input type='text' id="address" class="addrss" name='address' value='<?php echo $this->session->userdata['patient_info']['address'] ?>'></span> </br>
                    <span style="color:#036">Password:</span> <span class="password"><input type='password' id="password" class="pss" name='password' value=''></span> </br>
                    <div id="retype_password" style="display:none"></div>
                    <span style="color:#036">Age :</span> <span class="age"><input type="text" id="age" class="age" name="age" value="<?php echo $this->session->userdata['patient_info']['age'] ?>"></span> </br>
                    <span style="color:#036">Male :</span> <select name="gender" id="gender" class="male">
                        <option value="Male" <?php if ($this->session->userdata['patient_info']['gender'] == "Male") echo "selected"; ?>>Male</option>
                        <option value="Female" <?php if ($this->session->userdata['patient_info']['gender'] == "Female") echo "selected"; ?>>Female</option>
                    </select></br>
                    <span style="color:#036">Status :</span> <select name="marital_status" id="marital_status" class="status">
                        <option value="Single" <?php if ($this->session->userdata['patient_info']['marital_status'] == "Single") echo "selected"; ?>>Single</option>
                        <option value="Married" <?php if ($this->session->userdata['patient_info']['marital_status'] == "Married") echo "selected"; ?>>Married</option>
                    </select></br>
                    <span style="color:#036">Occupation :</span> <span class="occu"><input type="text" id="occupation" class="occu" name="occupation" value="<?php echo $this->session->userdata['patient_info']['occupation'] ?>"></span>
                </div>
                <input type="submit" name="submit" value ="Save" class="reg2" id="patient_edit_button"/>




<?php //echo form_close(); ?>




            </div>

            <script>
                $('#password').change(function(){
                    $('#retype_password').html("<span style='color:#036'>Retype Password:</span> <span class='re_password'><input type='password' id='text_retype_password'></span");
                    $('#retype_password').show('slow');
                })
            </script>
            <script>
                $('#text_retype_password').live('change',function(){
                    var retype = $('#text_retype_password').val();
                    var pass = $('#password').val();
                    if(retype != pass)
                    {
                        alert("Typed password does not match the first one. Please retype again");
                        $('#password').val("");
                        $('#text_retype_password').val("");
                    }
                })
            </script>
            <script>
                $('#patient_edit_button').click(function(){
                    var form_data = {
                        first_name : $('#first_name').val(),
                        mi : $('#mi').val(),
                        last_name : $('#last_name').val(),
                        password : $('#password').val(),
                        mobile_number : $('#mobile_number').val(),
                        email_add : $('#email_add').val(),
                        address : $('#address').val(),
                        age : $('#age').val(),
                        gender : $('#gender').val(),
                        marital_status : $('#marital_status').val(),
                        occupation : $('#occupation').val()
                    }
                    var con_first_name = form_validate(document.getElementById("first_name"));
                    var con_mi = form_validate(document.getElementById("mi"));
                    var con_last_name = form_validate(document.getElementById("last_name"));
                    var con_password = form_validate(document.getElementById("password"));
                    var con_mobile_number = form_validate(document.getElementById("mobile_number"));
                    var con_age = form_validate(document.getElementById("age"));
                    var con_gender = form_validate(document.getElementById("gender"));
                    var con_marital_status = form_validate(document.getElementById("marital_status"));

                    var con_occupation = form_validate(document.getElementById("occupation"));

                    if(!con_first_name || !con_mi || !con_last_name || !con_password || !con_mobile_number || !con_age || !con_gender || !con_marital_status)
                    {
                        alert("There are illegal characters found in your fields");
                    }
                    else
                    {

                        var retype = $('#text_retype_password').val();
                        if(retype != form_data['password'])
                        {
                            alert("Typed password does not match the first one. Please retype again");
                            $('#password').val("");
                            $('#text_retype_password').val("");
                        }
                        else
                        {
                            $.ajax({
                                url : "<?php echo base_url() ?>patient/profile_edit",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:'notification',text:msg});
                                    window.setTimeout(window.location=window.location
                                    , 2000);
                                }
                            })
                        }
                    }
                })
            </script>


            <div id="profile_photo" class="upload" style="display: none;">
                <script>
                    window.setTimeout(function(){
                        $('#photo_error').slideUp('slow');
                    }, 2000);
                </script>
<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "ufe") {
        ?>
                        <div id="photo_error" style=" border: solid 1px #F00"><p>The picture you picked was either oversized or a format that is not allowed</p></div>
        <?php
    }
}
?>
                <div id="form_bg">

<?php echo form_open_multipart('patient/upload', "id='uploader'"); ?>



                    <input type="file" name="userfile" size="20" id="upload_file"/>

                    </br></br>

                    <input type="submit" name="submit_uploader" value="upload" class="upld"/>

                </div>


<?php echo form_close(); ?>

            </div>



            <script type="text/javascript">
                $('#preview').change(function(){
                    var src = $(this).val();
                    $('#look').append("<img src='"+src+"'>");
                });
            </script>

            <script type="text/javascript">
                $('#look').click(function(){
                    var form_data = {
                        upload_data : $('#upload_file').data()
                    };
                    //alert(form_data['upload_data']);
                    //alert(form_data['upload_data']);
                    $.ajax({
                        url:"<?php echo base_url(); ?>patient/photo_preview",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                            //$('#success').html(msg);
                            //alert(msg);
                        }
                    })
                });

            </script>

            <script>
                $('#form_loader').toggle(
                function(){
                    //$('#form_div').append("<div id='forms'> <a href='#' id='form_hide'>HIDE ME!</a> First Name: <input type='text' value='<?php echo $patient_info['first_name'] ?>'> </br>Last Name: <input type='text' value='<?php echo $patient_info['last_name'] ?>'> </br>Email Address: <input type='text' value='<?php echo $patient_info['email_add'] ?>'> </br>Address: <input type='text' value='<?php echo $patient_info['address'] ?>'> </br>Password: <input type='text' value='<?php echo $patient_info['password'] ?>'></div>");
                    $('#forms').show('slow');
                    $('#form_loader').html('Hide');
                },
                function(){
                    $('#form_loader').html('Edit My Profile');
                    $('#forms').hide('slow');
                }
            );
                //});



                /*
               $('#form_loader').click(function(){
                   var forms = $('#forms').html();
                   $('#load').html(forms);
               });
                 */


            </script>

            <script>
                $('#button_uploader').click(function(){
                    $(this).submit();
                });
            </script>

            <script>
                /*   $('#click_to_load').on('click',function(){
                     $('#img_loader').show();
                    //$(this).fadeOut(1000);
                    var form_data = {
                        is_reschedule : true
                    }
            //$(document).ready(function(){
                    $.ajax({
                                url:"<?php echo base_url(); ?>patient-load-reservation-page",
                                type: 'POST',
                                data: form_data,
                                success: function(msg){
                                $('#loader').html(msg);
                                }
                            })
                });
                 */
            </script>


            <script>
                $('#loader').ajaxComplete(function(){
                    $('#img_loader').hide();
                });
            </script>


            <div id="previous_reservation_data" style="display: none; width: 300; height: 100">
                <div class="bg_table">
                    <center><h2>Would you like to keep your previous reservation data?</h2></br>
                        <div class="yes"><a style="cursor:pointer" id="yes_previous_reservation_data">Yes</a></div>
                        <div class="no"><a style="cursor:pointer" id="no_previous_reservation_data">No</a></div>
                    </center>
                </div>
            </div>
            <script>
                $('#yes_previous_reservation_data').click(function(){
                    $('#input_hidden_previous_reservation_data').val("1");
                    $('#form_reschedule').html("Date : <input type='text' id='date_reserve'/><input type='hidden' id='time'/><div id='time_available'></div><div id='time_reservation'> </div><div id='success'> </div>");
                    //$('#form_reschedule').show('slow');

                    $.fancybox.close();
                    $('#form_reschedule').show('slow');
                })
            </script>
            <script>
                $('#no_previous_reservation_data').click(function(){
                    //$('#link_load_reservation').fadeIn('slow');
                    $('#form_reschedule').fadeIn('slow');
                    $('#my_schedule').fadeOut('slow');
                    $.fancybox.close();
                })
            </script>
            <script>
                $('#reschedule').click(function(){
                    $('#link_load_reservation').fadeIn('slow');


                });
            </script>

            <script>
                $(function() {
                    $( "#date" ).datepicker({});
                    $('#date_reserve').datepicker({});
                    $('#date_resched_with_prev_data').datepicker({});
                });
            </script>

            <script>
                $('#click_to_load').click(function(){

                    $('#form_reschedule').fadeIn('slow');
                    $('#my_schedule').fadeOut('slow');

                });
            </script>


            <script type="text/javascript">

                $('#date_reserve').change(function(){
                    //alert($(this).val());


                    //alert(date.getDay());
                    var str = /[a-z\A-Z]/;
                    $('#img_loader').show(10);

                    var con = form_validate(document.getElementById("date_reserve"));
                    if(con)
                    {
                        var form_data = {
                            date : $(this).val(),
                            doctor_id : $('#doctor_id').val()
                        }

                            $.ajax({
                           url:"<?php echo base_url(); ?>patient/doctor_loader",
                           type: 'POST',
                           data: form_data,
                           success: function(msg){
                               $('#div_doctor_loader').html(msg);
                               expertise_loader($('#doctor_id').val());
                                interval = window.setInterval("func()", 2000);
                           }
                         })
                    }
                    else
                    {
                        alert("There are illegal characters found in the date field");
                        window.setTimeout(function(){$('#date_reserve').val("")}, 2000);
                    }
                });

                function func(){
                    //alert("alalaalla");
                    var day = new Date($("#date_reserve").val());
                    var form_data = {
                        doctor_id : $('#doctor_id').val(),
                        date : $("#date_reserve").val(),
                        day : day.getDay()

                    };
                    $.ajax({
                        url:"<?php echo base_url(); ?>patient-reservation-validate",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                            $('#time_available').html(msg);
                            //alert("aalalal");
                        }
                    })
                }
            </script>


            <script>
                $('#reserve_or_reschedule').live('click',function(){
                    var prev_data = $('#input_hidden_previous_reservation_data').val();
                    if(prev_data == "1")
                    {
                        var form_data = {
                            previous_data : prev_data,
                            date : $('#date_reserve').val(),
                            time : $('#time').val()
                        }

                        $.ajax({
                            url:"<?php echo base_url(); ?>patient-reschedule",
                            type: 'POST',
                            data: form_data,
                            success: function(msg){
                                $('#success').html(msg);
                            }
                        })

                    }
                    $('#img_loader').show();
                    //alert($(this).val());
                    var i = 0;
                    var service_id = '';
                    $('input:checked').each(function(){
                        //alert($('input:checked').get(i).name);
                        //alert($(''))
                        if(service_id == '')
                        {
                            service_id = $('input:checked').get(i).id;
                        }
                        else
                        {
                            service_id = service_id+","+$('input:checked').get(i).id;
                        }
                        i++;
                    });
                    if(i == 0)
                    {
                        i=1;
                    }

                    var name = $(this).text();
                    var form_data = {
                        doctor_id : $('#doctor_id').val(),
                        date : $('#date_reserve').val(),
                        time : $('#time').val(),
                        hour : i,
                        service_id : service_id,
                        specified_service : $('#specified_service').val(),
                        reservation_id : $('#reservation_id').val()
                    };

                    var con = form_validate(document.getElementById("date_reserve"));
                    var con2 = form_validate(document.getElementById("specified_service"));
                    if(con && con2)
                    {
                        //alert(form_data['doctor_id']+form_data['date']+form_data['time']);
                        if(form_data['doctor_id'] == "" || form_data['date'] == "" || form_data['time'] == "")
                        {
                            alert("Please fill out all the necessary information.");
                            $('#img_loader').hide();
                        }
                        else
                        {
                            if(name == "Reschedule")
                            {
                                //alert("Reschedule");
                                // alert(form_data['reservation_id']);
                                $.ajax({
                                    url:"<?php echo base_url(); ?>patient-reschedule",
                                    type: 'POST',
                                    data: form_data,
                                    success: function(msg){
                                        $('#success').html(msg);
                                    }
                                })
                            }
                            else
                            {
                                $.ajax({
                                    url:"<?php echo base_url(); ?>patient-reservation-validate",
                                    type: 'POST',
                                    data: form_data,
                                    success: function(msg){
                                        $('#success').html(msg);
                                    }
                                })
                            }
                        }
                    }
                    else
                    {
                        alert("There are illegal characters found in the field");
                        window.setTimeout(function(){$('#date_reserve').val("")}, 2000);
                    }
                });
            </script>
            <script>
                $('.prof_pic').hover(function(){
                    $('#change_picture').slideDown('slow')
                },
                function(){$('#change_picture').slideUp('slow')}
            );
            </script>
            <script>
                function expertise_loader(doctor_id)
                {
                    var form_data = {
                        doctor_id : doctor_id
                    };
                    $.ajax({
                        url : "<?php echo base_url() ?>doctor/doctor_expertise",
                        type : 'POST',
                        data : form_data,
                        success : function(msg){
                            var f = "<fieldset><legend> Expertise </legend>"+msg+"</fieldset>";
                            $('#doctor_expertise').html(msg);
                        }
                    });
                }
            </script>
            <script>
                $('#doctor_id').live('change',function(){

                    var form_data = {
                        doctor_id : $(this).val()
                    };
                    //alert(form_data['doctor_id']);
                    $.ajax({
                        url : "<?php echo base_url() ?>doctor/doctor_expertise",
                        type : 'POST',
                        data : form_data,
                        success : function(msg){
                            var f = "<fieldset><legend> Expertise </legend>"+msg+"</fieldset>";
                            $('#doctor_expertise').html(msg);
                        }
                    });


                    if($('#date_reserve').val() == "")
                    {
                        return false;
                    }
                    else
                    {
                        var day = new Date($('#date_reserve').val());

                        //alert(date.getDay());
                        $('#img_loader').show(10);
                        var form_data = {
                            doctor_id : $('#doctor_id').val(),
                            date : $('#date_reserve').val(),
                            day : day.getDay()

                        };
                        var con = form_validate(document.getElementById("date_reserve"));
                        var con2 = form_validate(document.getElementById("specified_service"));
                        if(con && con2)
                        {
                            //alert(form_data['day']);
                            $.ajax({
                                url:"<?php echo base_url(); ?>patient-reservation-validate",
                                type: 'POST',
                                data: form_data,
                                success: function(msg){
                                    $('#time_available').html(msg);
                                }
                            })
                        }

                        else
                        {
                            alert("There are illegal characters found in the field");
                            window.setTimeout(function(){$('#date_reserve').val("")}, 2000);
                        }
                    }
                });

                $(document).live('ready',function(){
                    var form_data = {
                        doctor_id : $('#doctor_id').val()
                    };
                    //alert(form_data['doctor_id']);
                    $.ajax({
                        url : "<?php echo base_url() ?>doctor/doctor_expertise",
                        type : 'POST',
                        data : form_data,
                        success : function(msg){
                            $('#doctor_expertise').html(msg);
                        }
                    })
                });

                $('#checker').click(function(){
                    var i = 0;
                    var n = $('input:checked').each(function(){
                        //alert($('input:checked').get(i).name);
                        //alert($(''))
                        i++;
                    });

                });
            </script>

            <script>
                $('.fancybox_history').click(function(){
                    var form_data = {
                        patient_id : this.name
                    }

                    $.ajax({
                        url : "<?php echo base_url() ?>patient/history",
                        type : 'POST',
                        data : form_data,
                        success : function(msg){
                            $('#my_history').html(msg);
                        }
                    })
                })
            </script>



            <script>
                $('.fancybox_tooth_history').click(function(){
                    var form_data = {
                        patient_id : this.name
                    }

                    $.ajax({
                        url : "<?php echo base_url() ?>patient/tooth",
                        type : 'POST',
                        data : form_data,
                        success : function(msg){
                            $('#my_history').html(msg);
                        }
                    })
                })
            </script>



            <script>
                $('#cancel_reservation').click(function(){
                    $.fancybox.open('#div_cancel_reservation');
                })
            </script>

            <div id="div_cancel_reservation" style="display: none; width: 300; height: 100">
               <div class="bg_table" style="height:92px;">
                    <center><h2>Do you really want to cancel your reservation?</h2></br>
                        <div class="yes"><a href="#" id="final_cancel_reservation">Yes</a> </div>
                        <div class="no"><a href="#" onClick="$.fancybox.close();" id="final_do_not_cancel">No</a></div>
                    </center>
                </div></div>


            <script>
                $('#final_cancel_reservation').click(function(){
                    var form_data = {
                        reservation_id : document.getElementById("cancel_reservation").name

                    }
                    // alert(form_data['reservation_id']);

                    $.ajax({
                        url : "<?php echo base_url() ?>patient/reservation_cancel",
                        type : "POST",
                        data : form_data,
                        success : function(msg){
                            noty({type:"notification",text:msg});
                            window.setTimeout(function(){
                                window.location = window.location;
                            }, 2000);
                        }
                    })
                })
            </script>

            <div id="my_notification" style="display: none; height: auto">
<?php
/* if(isset($notification_about_personal_message_info))
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

if (isset($notification_about_reservation_info)) {
    if (is_array($notification_about_reservation_info) && count($notification_about_reservation_info) > 0) {
        ?>
                        <div class="bg_table" style="padding:20px">
                            My Reservation
                            <div style="border: solid 1px #CCC; padding:10px; background: #fff;">
        <?php
        foreach ($notification_about_reservation_info as $notification) {

            if ($notification['status'] == "INACTIVE") {
                ?>
                                        <div style=" border: 1px solid #0C0; background: #cfc;">
                <?php
            } else {
                ?>
                                            <div style=" border: 1px solid #F90; background: #ffc;">
                <?php
            }
            ?>
                                            Date : <?php echo date("F d Y", strtotime($notification['date'])) ?></br>
                                            Message : <?php echo $notification['msg'] ?></br>

                                        </div>
                            <?php
                        }
                        ?>
                                </div>
                        <?php
                    } else {
                        ?>
                                You have no record yet.</br>
                        <?php
                    }
                }
                ?>
                    </div>
                </div>
            </div>
            <script>
                $('.patient_reply').click(function(){
                    $('#to_id').val(this.name);
                    //alert($('#to_id').val());
                    var i = $('#to_id').val();
                    $('#doctor_'+i).html("<textarea cols='25' rows='5' id='message'></textarea></br><input type='button' id='button_reply' value='Reply' align='right'>");
                    $('#doctor_'+i).show('slow');
                })
            </script>

            <script>
                $('#button_reply').live('click',function(){
                    var form_data = {
                        from_id : "<?php echo $this->session->userdata['patient_info']['id'] ?>",
                        to_id :  $('#to_id').val(),
                        msg : $('#message').val()
                    }
                    // alert(form_data['reservation_id']);

                    $.ajax({
                        url : "<?php echo base_url() ?>patient/notification_send_personal_message",
                        type : "POST",
                        data : form_data,
                        success : function(msg){
                            noty({type:"notification",text:msg});
                            window.setTimeout(function(){
                                window.location = window.location;
                            }, 2000);
                        }
                    })
                })
            </script>

            <script>
                $('.fancybox_notification').click(function(){
                    var form_data = {
                        notification_id : this.name
                    }

                    $.ajax({
                        url : "<?php echo base_url() ?>patient/notification_update",
                        type : "POST",
                        data : form_data,
                        success : function(msg){
                        }
                    })
                })
            </script>
            
            <script>
                $('#form_reschedule').mouseout(function(){
                    die(interval);
                });
            </script>


