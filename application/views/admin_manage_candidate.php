<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo "alalallalalallalah";

if( !defined('BASEPATH') ) exit ('No direct script access allowed');
    
    if(isset($candidates))
    {
        if(is_array($candidates) && count($candidates) > 0)
        {
            ?>
            <div style="border:1px solid #ccc; background:#EFEFEF; height:40px; width: auto;"><h4 style=" margin: 11px 15px;">Reservations for this day&nbsp;&nbsp;|   </h4></div> 
            <div id="admin_candidate" style="border-top:none;">
            <?php
            foreach($candidates as $candidate)
            {
                $patient_name = $candidate['patient_info']['first_name']." ".$candidate['patient_info']['last_name'];
                $time = $candidate['time'][0].$candidate['time'][1];
                                if($time<=11)
                                {
                                    $time = $time.":00 AM";
                                }
                                elseif($time == 12)
                                {
                                    $time = $time.":00 PM";
                                }
                                else
                                {
                                    $time = ($time-12).":00 PM";
                                }

                ?>
				<ul>
                    <li><img src="../../images/icon/user2.png" width="13" height="13"/>  Name : <?php echo $patient_name;?></li>
                    <li><img src="../../images/icon/alarm.png" width="13" height="13"/>  Time : <?php echo $time;?></li>
                    <li><img src="../../images/icon/contact2.png" width="13" height="13"/>  Mobile Number : <?php echo $candidate['patient_info']['mobile_number']?></li>
                    <li><img src="../../images/icon/msg.png" width="13" height="13"/>  Email : <a href="#email_patient" class="fancybox" name="<?php echo $candidate['patient_info']['email_add']?>"><?php echo $candidate['patient_info']['email_add']?></a></li>
                    <li>|  <a href="#" id="deactivate_reservation" name="<?php echo $candidate['id']?>">Cancel Reservation</a>
                     | <a href="#div_reschedule" class="fancybox" name="<?php echo $candidate['id']?>">Reschedule</a>  |</li></br>
                </ul><?php

            }
        }
        else
        {
            echo "There are no reservations for this hour";
        }
    }
?>
</div>
<script>
    $(document).ready(function(){
        document.getElementById("candidate_link").style.backgroundColor="#FFF";
        document.getElementById("candidate_link").style.padding="7px 15px 7px 73px";
    })
</script>

<div id="email_patient" style="display: none;width: 300">
<div style="border:1px solid #ccc; background:#F4F4F4; padding:10px; height:200px;">
    To : <div id="patient_email_add" align="left"></div>
    Subject : <span style="margin-left:10px; padding-left:2px;"><input type="text" id="subject" value="Confirm Reservation"></span> </br>
    Message : <textarea id="message" cols="32" rows="5"> </textarea></br>
    
    <input type="button" value="Send" id="send_email" class="pres_final_btn">
    
</div>
     
                    
<div id="div_reschedule" style="display: none; width: 350; height: 350"> 
<div style="border:1px solid #ccc; background:#F4F4F4; padding:10px;">
    <input type="hidden" id="input_reservation_id">
    Date : <input type="text" id="date"> 
    <div id="time_available" align="center"> </div>
    <div id="time_reservation" align="center"></div>
    <input type="hidden" id="time" value="">
    <div id="success" align="center"></div>
    <a href="#" id="button_reschedule" class="resched_btn">Reschedule</a>
</div>
</div>
</div>                  
                    
<script>
    $('.fancybox').click(function(){
        $('#patient_email_add').text(this.name);
    });
    
    $('#send_email').click(function(){
        var form_data = {
            subject : $('#subject').val(),
            message : $('#message').val(),
            email_add : $('#patient_email_add').text()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/patient_send_mail",
            type : "POST",
            data : form_data,
            success : function(msg){
                //alert(msg);
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
    })
</script>



<script>
    $('#deactivate_reservation').click(function(){
        var form_data = {
            reservation_id : this.name
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/reservation_deactivate",
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
    $('.fancybox').click(function(){
        $('#input_reservation_id').val(this.name);
        //alert($('#input_reservation_id').val());
        //alert(this.name);
    })
</script>
<script>
    $('#date').change(function(){
        //var dayToday = new Date($('#date').val());
        var form_data = {
            reservation_id : $('#input_reservation_id').val(),
            date : $('#date').val(),
            day : new Date($('#date').val()).getDay()
        }
        //alert($('#day').val());
        $.ajax({
            url : "<?php echo base_url()?>admin/reschedule",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#time_available').html(msg);
            }
        })
    });
</script>

<script>
    $(function() {
    $("#date").datepicker({});
  });
</script>
<script>
    $('#button_reschedule').click(function(){
        if($('#input_reservation_id').val() == "" || $('#date').val() == "" || $('#time').val() == "")
        {
            alert("Please fill out all the information");
        }
        else
        {
             var form_data = {
                reservation_id : $('#input_reservation_id').val(),
                date : $('#date').val(),
                time : $('#time').val()
            }
            //alert(form_data['time']);
            $.ajax({
                url : "<?php echo base_url()?>admin/reschedule_validate",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('#success').html(msg);
                    //alert("asfsdgsgs");
                }
            })
        }
    })
</script>

