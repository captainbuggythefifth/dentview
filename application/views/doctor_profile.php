<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
    
            $is_reserve_or_reschedule = "Reschedule";
            //print_r($this->session->userdata);
?>
<body>
<div id="middle_box2">
        	<div class="left_box">
                    <div class="prof_pic" style="background:url(<?php echo base_url().$this->session->userdata['doctor_info']['photo_info']['source'];?>)no-repeat center;">
                
                </div>
                <div style="margin: 5px 55px 0 55px;"><h2><?php echo $this->session->userdata['doctor_info']['first_name']." ".$this->session->userdata['doctor_info']['mi']." ".$this->session->userdata['doctor_info']['last_name']; ?></h2></div>
                <div class="box">
                	<div class="inline">
                	<ul>
          				<li><a class="fancybox" href="#inline1" title="Profile Edit">Edit Profile</a></li>
          				<li><a class="fancybox" href="#profile_photo" title="Change profile photo">Upload Photo</a></li>
                                        <li><a href="#my_expertise" id="expertise" class="fancybox">My Expertise</a></li>
                        
          				
        			</ul>
                	</div>
                </div>
                <div class="box">
                <ul>
          				<li>Name: <a href="#inline1"><?php echo $this->session->userdata['doctor_info']['first_name']." ".$this->session->userdata['doctor_info']['mi']." ".$this->session->userdata['doctor_info']['last_name']; ?></a></li>
          				<li>Age: <a href="#inline1">22</a></li>
          				<li>Address: <a href="#inline1"><?php echo $this->session->userdata['doctor_info']['address']?></a></li>
          				<li>Contact: <a href="#inline1"><?php echo $this->session->userdata['doctor_info']['email_add']?></a></li>
                                        <li>Message: (<a id="doctor_personal_message" href="#div_personal_message"><?php echo count($notification_about_personal_message_info)?></a>)</li>
                                        <li>Reservation: (<a id="fancybox_doctor_reservation" href="#div_doctor_reservation"><?php echo count($notification_about_reservation_info)?></a>)</li>
                                        <li>Log Out: <a href="#" id="log_out">LOG OUT</a></li>
                                        
                </ul>
                </div>
                <div class="link">
                <ul>
                	<a id="show_guide">Show Guides</a>
                </ul>
                </div>
            	<div id="guide" style="display:none"> <p> &nbsp; &nbsp; &nbsp; &nbsp; Lorem ipsum dolor sit amet, consectetur ipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Lorem ipsum dolor sit amet, consectetur ipisicing elit. Lorem ipsum dolor sit amet am.</p>
                </div>
                
            </div>
    		<div class="right_box">
            
            	<div class="table" style="height:500">
                    
                    
         

         <!-- <input type="text" id="date"> -->
    <div id="tabs" style="height:493">
            <ul>
		<li><a href="#link_load_reservation" id="click_to_load_doctor"><?php echo $is_reserve_or_reschedule; ?></a></li>
                
            </ul>

        
         <div id="my_schedule">
                Select Date:
                <input type="text" id="date_main">
                <div id="time_available_main"> </div>
            </div>
        
        

        <div id="reservation_div">
            <div id="link_load_reservation">
                <!--<div id="click_to_load"><center><h3>My Schedule</h3></center></div> -->
                <div id="img_loader" style="display: none;"> <img src="<?php base_url()?>images/loading.gif" style="height: 20;width: 20"> </div>
                <div id="loader"> </div>
                <div id="form_reschedule" style="display:none">
                    <?php
                        $doctors = $this->doctor_model->get_all();
                        if(count($doctors) > 0)
                        {
                            if(count($doctors) == 1)
                            {
                    ?>
         Doctor Assigned: <?php echo $doctors[0]['first_name']." ".$doctors[0]['last_name']?>   <input id="doctor_id" type="hidden" value="<?php echo $doctors[0]['id']?>" name="doctor_id">
                    <?php
                            }
                            else
                            {
                    ?>
         Select Doctor:  <select id="doctor_id" name="doctor_id" style="width: 150px; height: 2.2em; display:block;" title="Click me to Select Doctor">
		<?php foreach($doctors as $doctor){ ?>
		<option value="<?php echo $doctor['id']?>"><?php echo $doctor['first_name']." ".$doctor['last_name']?></option>
		<?php } ?>
                </select>
                        
                        <?php
                            }
                        }
    
                        else 
                        {
                        ?>
    
                         Doctor Assigned: Joel Taytayan   <input type="hidden" value="0" name="doctor_id" id="doctor_id">
    
                        <?php
                        }
                        
                    ?>
               <p id="d">     Date: </p>
                        <input type="text" id="date">
                        <input type="hidden" id="time">
                        <input type="hidden" id="reservation_id">
                     <div id="time_reservation"> </div>   
                    <div id="time_available"> </div>
                    
                    <div>
                    
                    
                    <div id="success"> </div>
                </div>

            </div>
            
           
                </div>
        
         
          </div>
      </div>
                <div id="btn">
                <div class="inline">
                	<ul>
          				<li><a id="reserve_or_reschedule" class="rsrv_btn"><?php echo $is_reserve_or_reschedule; ?></a></li>
        			</ul>
                	</div>
              
                </div>
                
            </div>
            
           

</div>
 <div id="inline1" style="width:400px;display: none;">
		<h3>EDITING MY PROFILE</h3>
		<div id='forms'>
    <?php 
    if(isset($msg))
    {
        echo $msg;
        unset($msg);
    }
?>
<? echo form_open('doctor/profile_edit'); ?>
<?php 
    $pass = $this->session->userdata['doctor_info']['password'];
    $patient = array(
            'first_name' => 'first_name',
            'mi' => 'mi',
            'last_name' => 'last_name',
            'email_add' => 'email_add',
            'password'  => 'password',
            'address' => 'address'
    );
?>

    First Name: <input type='text' name='first_name' value='<?php echo $this->session->userdata['doctor_info']['first_name']?>'> </br>
    Middle Initial: <input type='text' name='mi' value='<?php echo $this->session->userdata['doctor_info']['mi']?>'> </br>
    Last Name: <input type='text' name='last_name' value='<?php echo $this->session->userdata['doctor_info']['last_name']?>'> </br>
    Email Address: <input type='text' name='email_add' value='<?php echo $this->session->userdata['doctor_info']['email_add']?>'> </br>
    Address: <input type='text' name='address' value='<?php echo $this->session->userdata['doctor_info']['address']?>'> </br>
    Password: <input type='hidden' name='password' value='<?php echo $pass?>'> </br>
    
    <input type="submit" name="submit" value ="Save"/>
    
    
    <?  echo form_close();?>
    
    
    
    
    </div>
</div>


<div id="profile_photo" style="display: none; width: 400px; height: 400px">

    <?php echo form_open_multipart('doctor/upload',"id='uploader'");?>
    
    

    <input type="file" name="userfile" size="20" id="upload_file"/>

    <br /><br />
    <input type="submit" value="Upload">
    
    </form>
    
</div>
    
<div id="my_expertise" style="display: none;width: 200;height: 200">
                    <?php
                    if(isset($this->session->userdata['doctor_info']['expertise_with_service']))
                    {
                        ?>
                        <fieldset> <legend> My Expertise </legend>
                    <?php
                        $expertise_with_service = $this->session->userdata['doctor_info']['expertise_with_service'];
                        if(isset($expertise_with_service))
                        {
                            $str_id = "";
                            foreach($expertise_with_service as $serv)
                            {
                              
                                    $str_id = $str_id.",".$serv['id'];
                                    ?>
                                    <p> <?php echo $serv['name']?> </p>
                                    
                                    <?php
                               
                                
                            }
                            ?>
                            </fieldset>
                            <input type="hidden" id="all_service_id" value="<?php echo $str_id; ?>">
                            <?php
                        }
                    }
                    ?>
    <a href="#" id="add_expertise">Add Expertise</a>
    <div id="services_loader"></div>
</div>
</body>

<script>
    $('#add_expertise').click(function(){
        var form_data  = {
            str : $('#all_service_id').val()
        };
        //alert(form_data['str']);
//        $.get('<?php base_url()?>doctor/services_loader',{input: str},function(data){
//            alert(data);
//        });
        $.ajax({
            url: "<?php echo base_url()?>doctor/services_loader",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#services_loader').html(msg);
                $('#service_loader').show("slow");
            }
        })
    });
</script>


<script type="text/javascript"> 
    $('#preview').change(function(){
        var src = $(this).val();
        $('#look').append("<img src='"+src+"'>");
    });
</script>
<script>
    $('#click_to_load_doctor').click(function(){
        $('#form_reschedule').hide('slow');
        $(this).html("Reschedule");
        $('#my_schedule').show('slow');
        
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
                    url:"<?php echo base_url();?>patient/photo_preview",
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
        //$('#form_div').append("<div id='forms'> <a href='#' id='form_hide'>HIDE ME!</a> First Name: <input type='text' value='<?php echo $doctor_info['first_name']?>'> </br>Last Name: <input type='text' value='<?php echo $doctor_info['last_name']?>'> </br>Email Address: <input type='text' value='<?php echo $doctor_info['email_add']?>'> </br>Address: <input type='text' value='<?php echo $doctor_info['address']?>'> </br>Password: <input type='text' value='<?php echo $doctor_info['password']?>'></div>");
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
                    url:"<?php echo base_url();?>patient-load-reservation-page",
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

<script>
    $('#show_guide').click(function(){
        var str = $(this).text();
        if(str == "Show Guides")
        {
            $('#guide').fadeIn('slow');
            $(this).html('Hide Guides');
        }
        if(str == "Hide Guides")
        {
            $('#guide').hide('slow');
            $(this).html('Show Guides');
        }
    });
</script>

<script>
    $('#reschedule').click(function(){
        $('#link_load_reservation').fadeIn('slow');
    });
</script>

<script>
    $(function() {
    $( "#date" ).datepicker({});
  });
</script>

<script>
    $(function() {
    $( "#date_main" ).datepicker({});
  });
</script>

<script>
    $('#click_to_load').click(function(){
        var get = $(this).text();
        //alert(get);
        
        $('#form_reschedule').hide('slow');
        $(this).html("Reschedule");
        $('#my_schedule').show('slow');
        
        
    });
</script>


<script type="text/javascript">
    $('#date').change(function(){
        //alert($('#reservation_id').val());
        var day = new Date($(this).val());
        $('#img_loader').show(10);
        var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $(this).val(),
            reservation_id : $('#reservation_id').val(),
            day : day.getDay()
            
        };
        $.ajax({
            url:"<?php echo base_url();?>doctor-reservation-of-date",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#time_available').html(msg);
            }
        })
    });
    
</script>



<script type="text/javascript">
    $('#date_main').change(function(){
        $('#img_loader').show(10);
        var day = new Date($(this).val());
        var form_data = {
            date : $(this).val(),
            day : day.getDay()
        };
        $.ajax({
            url:"<?php echo base_url();?>doctor-reservation-of-date",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#time_available_main').html(msg);
               //alert(msg);
            }
        })
    });
    
</script>



<script>
$('#reserve_or_reschedule').click(function(){
            $('#img_loader').show();
            
                        
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
                date : $('#date').val(),
                time : $('#time').val(),
                hour : i,
                service_id : service_id,
                specified_service : $('#specified_service').val(),
                reservation_id : $('#reservation_id').val()
            };
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
                    alert(form_data['reservation_id']);
                    //alert("Reschedule");
                   // alert(form_data['reservation_id']);
                    $.ajax({
                        url:"<?php echo base_url();?>doctor/reshedule",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                        //$('#success').html(msg);
                        noty({type:"notification",text:msg});
                        window.setTimeout(function(){
                            window.location = window.location;
                        }, 2000);
                        }
                    })
                }
                else
                {
                    $.ajax({
                        url:"<?php echo base_url();?>patient-reservation-validate",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                        $('#success').html(msg);
                        }
                    })
                   // window.setInterval(history.go(0), delay, param1, param2)
                }
            }
        });
</script>
<script>
    $('#doctor_id').change(function(){
        
        var form_data = {
            doctor_id : $(this).val()
        };
        //alert(form_data['doctor_id']);
        $.ajax({
            url : "<?php echo base_url()?>doctor/doctor_expertise",
            type : 'POST',
            data : form_data,
            success : function(msg){
                $('#doctor_expertise').html(msg);
            }
        })
    });
    
    $(document).ready(function(){
        var form_data = {
            doctor_id : $('#doctor_id').val()
        };
        //alert(form_data['doctor_id']);
        $.ajax({
            url : "<?php echo base_url()?>doctor/doctor_expertise",
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
    $('#log_out').click(function(){
        var form_data = {
            doctor_id : "<?php echo $this->session->userdata['doctor_info']['id']?>"
        }
        
        
        $.ajax({
            url : "<?php echo base_url()?>doctor/log_out",
            type : 'POST',
            data : form_data,
            success : function(msg){
                //$('#doctor_expertise').html(msg);
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
        
    })
</script>

<div id="div_personal_message" style="display:none; width: 300; height: 300">
    <?php if(isset($this->session->userdata['doctor_info']['notification_about_personal_message_info']))
        {
            if(is_array($this->session->userdata['doctor_info']['notification_about_personal_message_info']) && count($this->session->userdata['doctor_info']['notification_about_personal_message_info']) > 0)
            {
                $i = 0;
                $count = count($this->session->userdata['doctor_info']['notification_about_personal_message_info']);
                foreach($this->session->userdata['doctor_info']['notification_about_personal_message_info'] as $notification)
                {
                    $i++;
                    if($count != $i)
                    {
                        ?>
                        <div style=" border: solid 1px #99ffff; padding: 5px">
                        From : <?php echo $notification['patient_info']['first_name']." ".$notification['patient_info']['last_name']?></br>
                        Message : <?php echo $notification['msg']?></br>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div style=" border: solid 1px #99ffff; padding: 5px">
                        From : <?php echo $notification['patient_info']['first_name']." ".$notification['patient_info']['last_name']?></br>
                        Message : <?php echo $notification['msg']?></br>
                        <a class="doctor_reply" style="cursor:pointer;" name="<?php echo $notification['patient_info']['id']?>">Reply</a>
                        <input type="hidden" id="to_id">
                        <div id="patient_<?php echo $notification['patient_info']['id']?>" style="display:none"></div>
                        </div>
                        <?php
                    }
                    
                }
            }
        }
        
        ?>
</div>

<script>
    $('.doctor_reply').click(function(){
        $('#to_id').val(this.name);
        //alert($('#to_id').val());
        var i = $('#to_id').val();
        $('#patient_'+i).html("<textarea cols='25' rows='5' id='message'></textarea></br><input type='button' id='button_reply' value='Reply' align='right'>");
        $('#patient_'+i).show('slow');
    })
</script>

<script>
    $('#button_reply').live('click',function(){
        var form_data = {
            from_id : "<?php echo $this->session->userdata['doctor_info']['id']?>",
            to_id : $('#to_id').val(),
            msg : $('#message').val()
        }
        
        if(form_data['msg'] == "")
        {
            return false;
        }
        else
        {
            $.ajax({
            url : "<?php echo base_url()?>doctor/notification_send_personal_message",
            type : 'POST',
            data : form_data,
            success : function(msg){
                //$('#doctor_expertise').html(msg);
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
                }
            })
        }
    })
</script>

<div id="div_doctor_reservation" style="display:none;width:300;height:300">
    <?php
            if(isset($notification_about_reservation_info))
            {
                //print_r($notification_about_reservation_info);
                $notification_about_reservation_info = $notification_about_reservation_info;
                    foreach($notification_about_reservation_info as $notification)
                    {
                        
                        if($notification['status'] == "INACTIVE")
                        {
                        ?>
                            <div style=" border: solid #0C0">

                            Date : <?php echo date("F d Y",  strtotime($notification['date']))?></br>
                            Message : <?php echo $notification['msg']?></br>
                            </div>
                        <?php
                        }
                        else
                        { ?>
                            <div style=" border: solid #F00">
                                Date : <?php echo date("F d Y",  strtotime($notification['date']))?></br>
                            Message : <?php echo $notification['msg']?></br>
                            
                            <a style=" cursor: pointer" class="my_date_doctor" name="<?php echo $notification['id']?>">Look at My Date</a>
                            </div>
                        <?php
                        }
                        ?>
                            
                        <?php
                    }
            }
                ?>
                                
</div>
<script>
    $('.my_date_doctor').click(function(){
        var form_data = {
            notification_id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>doctor/notification_update",
            type : 'POST',
            data : form_data,
            success : function(msg){
                    if(msg[0].isNumber()){ 
                        $('#date_main').val(msg);
                        $.fancybox.close();
                    }
                    else
                    {
                        alert("The patient has already cancelled his reservation");
                    }
                }
            })

        
    })
</script>







