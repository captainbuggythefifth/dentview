<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>

<html>
<head>

    <script type="text/javascript" src="<?php echo base_url()?>javascript/datePicker/jquery-1.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>javascript/datePicker/jquery-ui-1.7.1.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>javascript/datePicker/daterangepicker.jQuery.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.daterangepicker.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />
		<script type="text/javascript">	
			$(function(){
				  $('#inputField').daterangepicker({arrows:true}); 
			 });
		</script>
    
    
    
    </head>
<body>
    <?php if(isset($this->session->userdata['patient_info']['reservation_info']))
        {
            $reservation_info = $this->session->userdata['patient_info']['reservation_info'];
            if(count($reservation_info) > 0)
            {
        
        ?>
    <div id="reservation_div">
        <input type="hidden" id="reservation_id" value="<?php echo $reservation_info['id']?>">
            <?php
            if(isset($reservation_info['time']))
              {
             ?>
            My Schedule: </br>
            Time: 
            <?php 
                
                    $time = $reservation_info['time'][0].$reservation_info['time'][1];
                    if($time<11)
                    {
                        echo $time.":00 AM";
                    }
                    elseif($time == 12)
                    {
                        echo $time.":00 PM";
                    }
                    else
                    {
                        echo ($time-12).":00 PM";
                    }
                ?>
                Date: 
                <?php 
                    $date = new DateTime($reservation_info['date']);
                    echo date_format($date,"F d Y");
                }
            }
        }
                ?>
        </div>
    <?php 
    if(isset($is_reserved))
    {
        if($is_from=="reservation" && is_array($is_reserved) && $is_reserved != false)
        {
            echo "You have an active reservation. You can always re-schedule.";
        }
        
        else
        {
        
        
    
    if(isset($this->session->userdata['patient_info']['id']))
    {
        
    
?>
<!-- <form method="post" action="<?php base_url()?>patient-reservation-validate"> -->
    <?php echo form_open('patient-reservation-validate'); ?>
    <?php 
    $reservation_info = array(
            //'time' => 'time',
            'date'  => 'date',
            'doctor_id' => 'doctor_id',
            //'time' => 'time'
    );
?>
<?php if(isset($doctors))
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
         Select Doctor: <select id="doctor_id" name="doctor_id" class="admin_slct" style="width: 150px; height: 2.2em; display:block;" title="Click me to Select Doctor">
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
         </br>
         
         
    <?php $afternoon = false; ?>
<div id="inline1" style="width:1000px;display: none;">
		<h3>Etiam quis mi eu elit</h3>
		<p>
			<?php 
                        for($i=8;$i<20;$i++)
                        {
                            ?>
                            <div style="width:100px;background-color:grey"> 
                                <?php 
                                if($i>12)
                                { 
                                    echo ($i-12).':00 PM'; 
                                    $afternoon=true;
                                }
                                else 
                                {
                                    echo $i.":00 AM";
                                }
                                ?> 
                            </div>
                    <?php
                        }
                        ?>
		</p>
</div>
         
       
   <!--  Time <input name="time" type="text" class="rangeB" style="width: 150px; height: 2.2em; display:block;" title="Click me to Select Time" onclick="this.value=''" required="required"> </br>
    Date <input type="text" id="rangeA" title="Click me to Select Date" onclick="this.value=''" required="required"> </br>
    
   -->
   <input type="text" value="" id="inputField" style="width: 150px; height: 1.5em; display:block;" title="Click me to Select Date"/>
   <input type="hidden" id="time" name="time" value=""/>
    
    <div id="time_available">
    </div>
    
    <div id="time_reservation">
        </div>
   
   <input type="text" id="date">
 
 <script>
    $(function() {
    $( "#date" ).datepicker({});
  });
</script>

     
   <!-- </form> -->
   <input type="submit" id="check" value="Check" onclick=""/>
   <input type="button" id="reserve" 
          value="<?php 
                if(isset($is_from))
                {
                    if($is_from == "reschedule")
                        echo "Reschedule";
                    else
                        echo "Reserve";
                }
                else
                    echo "Reserve";
                    ?>" onclick=""/>
<?php echo form_close()?>
    <div id="success">
        </div>
   
   <?php echo validation_errors('<p class="errors"></p>')?>
<?php }
else {
    ?>
    Please go back to <a href="<?php echo base_url()?>">Home</a> for you haven't logged in yet. 
    <?php
    }
    }
    }
    ?>
    
    
    
</body>
</html>
<script type="text/javascript">
    $('#inputField').change(function(){
        $('#img_loader').show(10);
        var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $('#inputField').val()
            
        };
        $.ajax({
            url:"<?php echo base_url();?>patient-reservation-validate",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#time_available').html(msg);
            }
        })
    });
    
</script>
<script type="text/javascript">
    $('#check').click(function(){
        $('#img_loader').show();
        var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $('#inputField').val()
        };
        if(form_data['date'] == "")
        {
            $('#img_loader').hide();
            alert("Please fill out the Date");
        }
        else
        {
        $.ajax({
            url:"<?php echo base_url();?>patient-reservation-validate",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#time_available').html(msg);
            }
        })
        }
        return false;
	});
        
       
</script>
<script>
$('#reserve').click(function(){
            $('#img_loader').show();
            //alert($(this).val());
            var name = $(this).val();
            var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $('#inputField').val(),
            time : $('#time').val(),
            reservation_id : $('#reservation_id').val()
            };
            
            //alert(form_data['doctor_id']+form_data['date']+form_data['time']);
            if(form_data['doctor_id'] == "" || form_data['date'] == "" || form_data['time'] == null)
            {
                alert("Please fill out all the necessary information.");
            }
            else
            {
                
                if(name == "Reschedule")
                {
                    //alert("Reschedule");
                   // alert(form_data['reservation_id']);
                    $.ajax({
                        url:"<?php echo base_url();?>patient-reschedule",
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
    $('#reserve').ajaxComplete(function(){
        $('#img_loader').hide();
    });
</script>

<script>
    $('#check').ajaxComplete(function(){
        $('#img_loader').hide();
    });
</script>

<script>
    $('#inputField').ajaxComplete(function(){
        $('#img_loader').hide();
    });
</script>