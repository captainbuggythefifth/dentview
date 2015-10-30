<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    $(document).ready(function(){
        document.getElementById("system_link").style.backgroundColor="#FFF";
        document.getElementById("system_link").style.padding="7px 15px 7px 73px";
    })
</script>
<div id="div_time_change" style="display: none; width: 300; height: 150">
</div>
<script>
    $(function(){
        $('#date').datepicker({});
    })
</script>

<?php if(isset($system_info))
{
    
    if(is_array($system_info) && count($system_info) > 0)
    {
       
        if($system_info['whole_day'] == false)
        {
        ?>
        <div id="" style=" border:1px solid #ccc; background:#EFEFEF; padding:10px;">
        There has been a scheduled time for today. </br>
        Today's time is from
         <?php 
         if(is_numeric($system_info['time_in'][1]))
         {
             $i = $system_info['time_in'][0].$system_info['time_in'][1];
         }
         else
         {
             $i = $system_info['time_in'][0];
         }
           
             if($i<=11)
            {
                echo $i.":00 AM"; 

            }
            elseif($i==12)
            {
                echo $i.':00 PM';
            }
            else 
            {
                 echo ($i-12).':00 PM'; 
                $afternoon=true;      
            }
            
            echo " to ";
            
            if(is_numeric($system_info['time_out'][1]))
             {
                 $i = $system_info['time_out'][0].$system_info['time_out'][1];
             }
             else
             {
                 $i = $system_info['time_out'][0];
             }
             
             //echo $i;
             
             if($i<=11)
            {
                echo $i.":00 AM"; 

            }
            elseif($i==12)
            {
                echo $i.':00 PM';
            }
            else 
            {
                 echo ($i-12).':00 PM'; 
                $afternoon=true;      
            }
                        
        ?> &nbsp; 
        </div>
            <?php
    }
    else
    {
        ?>
        Cancellation is whole day now. 
        <?php
    }
    ?>
    <div style="border:1px solid #ccc; background:#F7F7F7; border-top:none; padding:10px;">
        <a href="#div_time_change" class="fancybox_change_time add_patient" name="<?php echo $system_info['id']?>">Change Time</a> </br>
        <?php
    }
}
?>
<div id="" style=" border:1px solid #ccc; background:#EFEFEF; padding:10px;">Set a Date to be scheduled</div>
<div style="border:1px solid #ccc; background:#F7F7F7; border-top:none; padding:10px;">Date : <input type="text" id="date">

<select id="time_in">
<?php
                        
                                for($i=10;$i<24;$i++)
                                {
                                ?>

    <option value="<?php echo $i?>">

                                <?php
                               
                                
                                if($i<=11)
                                {
                                    echo $i.":00 AM"; 
                                       
                                }
                                elseif($i==12)
                                {
                                    echo $i.':00 PM';
                                }
                                else 
                                {
                                     echo ($i-12).':00 PM'; 
                                    $afternoon=true;      
                                }
     
                                ?> 
        </option>
                    <?php
                            }
?>
    </select>

<select id="time_out">
<?php
                        
                                for($i=8;$i<20;$i++)
                                {
                                ?>

    <option value="<?php echo $i?>" <?php if($i == 19) echo "selected"?>>

                                <?php
                               
                                
                                if($i<=11)
                                {
                                    echo $i.":00 AM"; 
                                       
                                }
                                elseif($i==12)
                                {
                                    echo $i.':00 PM';
                                }
                                else 
                                {
                                     echo ($i-12).':00 PM'; 
                                    $afternoon=true;      
                                }
     
                                ?> 
        </option>
                    <?php
                            }
?>
    </select>

    
<input type="checkbox" id="whole_day" value="0" >Whole Day &nbsp;

<input type="button" value="Save" id="button_time_save" class="add_patient">
<div id="div_reservation_of_this_date"></div>
</div>
</div>
<script>
    $('#button_time_save').click(function(){
        var form_data = {
            date : $('#date').val(),
            time_in : $('#time_in').val(),
            time_out : $('#time_out').val(),
            whole_day : $('#whole_day').val()
            
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/system_save",
            type : "POST",
            data : form_data,
            success : function(msg){     
                noty({type:'notification',text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
    })
</script>

<script>
    $('input:checkbox').click(function(){
        //alert("asffhgjh");
        if(document.getElementById("time_in").disabled == false)
        {
            document.getElementById("time_in").disabled = true;
             document.getElementById("time_out").disabled = true;
             $(this).val("1");
             //$('#time_in').val("");
        }
        else
        {
            document.getElementById("time_in").disabled = false;
             document.getElementById("time_out").disabled = false;
             $(this).val("0");
        }
    })
</script>

<script>
    $('.fancybox_change_time').live('click',function(){
        var form_data = {
           id : this.name
        }
        alert(form_data['id']);
        $.ajax({
            url : "<?php echo base_url()?>admin/system_edit",
            type : "POST",
            data : form_data,
            success : function(msg){     
                //noty({type:'notification',text:msg});
                $('#div_time_change').html(msg);
            }
        })
    })
</script>

<script>
    $('#date').change(function(){
        var form_data = {
           date : $(this).val(),
           time_in : $('#time_in').val(),
           time_out : $('#time_out').val(),
           whole_day : $('input:checkbox').val()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/system_date_check",
            type : "POST",
            data : form_data,
            success : function(msg){     
                //noty({type:'notification',text:msg});
                $('#div_reservation_of_this_date').html(msg);
            }
        })
    })
</script>

<script>
    $('#time_in').change(function(){
        var date = $("#date").val();
        if(date != ""){
        var form_data = {
           date : $("#date").val(),
           time_in : $('#time_in').val(),
           time_out : $('#time_out').val(),
           whole_day : $('input:checkbox').val()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/system_date_check",
            type : "POST",
            data : form_data,
            success : function(msg){     
                //noty({type:'notification',text:msg});
                $('#div_reservation_of_this_date').html(msg);
            }
        })
        }
    })
</script>

<script>
    $('#time_out').change(function(){
        var date = $("#date").val();
        if(date != ""){
        var form_data = {
           date : $("#date").val(),
           time_in : $('#time_in').val(),
           time_out : $('#time_out').val(),
           whole_day : $('input:checkbox').val()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/system_date_check",
            type : "POST",
            data : form_data,
            success : function(msg){     
                //noty({type:'notification',text:msg});
                $('#div_reservation_of_this_date').html(msg);
            }
        })
        }
    })
</script>


<script>
    $('input:checkbox').change(function(){
        var date = $("#date").val();
        if(date != ""){
        var form_data = {
           date : $("#date").val(),
           time_in : $('#time_in').val(),
           time_out : $('#time_out').val(),
           whole_day : $('input:checkbox').val()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/system_date_check",
            type : "POST",
            data : form_data,
            success : function(msg){     
                //noty({type:'notification',text:msg});
                $('#div_reservation_of_this_date').html(msg);
            }
        })
        }
    })
</script>


<div id="div_reschedule" style="display: none; width: 350; height: 300"> 
<div style="border:1px solid #ccc; background:#F4F4F4; padding:10px;">
    <input type="hidden" id="input_reservation_id">
    <input type="hidden" id="time">
    Date : <input type="text" id="date_reschedule"> 
    <div id="time_avail" align="center"> </div>
    <div id="time_reservation_for_admin" align="center" ></div>
    <input type="hidden" id="time_for_admin" value="">
    <div id="success"></div>
    <a href="#" id="button_reschedule" class="resched_btn">Reschedule</a>
</div>
<script>
    $('.fancybox_send_email').live('click',function(){
        $('#patient_email_add').text(this.name);
            return false;
    })
</script>
<script>
    $('.fancybox_resched').live('click',function(){
       
            $('#input_reservation_id').val(this.name);
    });
</script>

<script>
    $('#final_cancel_reservation').live('click',function(){

       var form_data = {
            reservation_id : $('#current_reservation').val()
        }
       // alert(form_data['reservation_id']);

        $.ajax({
            url : "<?php echo base_url()?>admin/reservation_cancel",
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
    $('.fancybox_cancellation').live('click',function(){
        $('#current_reservation').val(this.name);
        //alert($('#current_reservation').val());
    })
</script>

<script>
    $('#date_reschedule').change(function(){
        //var dayToday = new Date($('#date').val());
        var form_data = {
            reservation_id : $('#input_reservation_id').val(),
            date : $('#date_reschedule').val(),
            day : new Date($('#date_reschedule').val()).getDay()
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/reschedule",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#time_avail').html(msg);
            }
        })
    });
</script>

<script>
    $(function() {
    $("#date_reschedule").datepicker({});
  });
</script>

<script>
    $('#button_reschedule').click(function(){
        if($('#input_reservation_id').val() == "" || $('#date_reschedule').val() == "" || $('#time').val() == "")
        {
            alert("Please fill out all the information");
        }
        else
        {
             var form_data = {
                reservation_id : $('#input_reservation_id').val(),
                date : $('#date_reschedule').val(),
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

<script>
    $('#time_in').change(function(){
        var time_in = $(this).val();
        var i = 0;
        for(i = time_in; i < 20; i++)
        {
            document.getElementById("time_out").value = i;
        }
    })
</script>


<div id="email_patient" style="display: none;width: 300">
<div style="border:1px solid #ccc; background:#F4F4F4; padding:10px; height:200px;">                        
    To : <div id="patient_email_add" align="left"></div>
    Subject : <span style="margin-left:10px; padding-left:2px;"><input type="text" id="subject" value="Cancellation of Reservation"></span> </br>
    Message : <textarea id="message" cols="32" rows="5"> </textarea></br>

    <input type="button" value="Send" id="send_email" class="pres_final_btn">
</div>
</div>
<script>
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

<div id="div_cancel_reservation" style="display: none; width: 300; height: 300">
    <input type="hidden" id="current_reservation">
        <center>Do you really want to cancel your reservation?</br>
        <a href="#" id="final_cancel_reservation">Yes</a> <a href="#" onclick="$.fancybox.close();" id="final_do_not_cancel">No</a>
        </center>
</div>