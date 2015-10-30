<HTML>
    
<HEAD>
<TITLE></TITLE>
<META NAME="Generator" CONTENT="TextPad 4.6">
<META NAME="Author" CONTENT="?">
<META NAME="Keywords" CONTENT="?">
<META NAME="Description" CONTENT="?">


<!-- Start of fancy box -->
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

  
<script type="text/javascript" src="<?php echo base_url()?>/javascript/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/javascript/fancybox/lib/jquery-1.8.0.min.js"></script>

	
<script type="text/javascript" src="<?php echo base_url()?>javascript/datePicker/jquery-1.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>javascript/datePicker/jquery-ui-1.7.1.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>javascript/datePicker/daterangepicker.jQuery.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>css/ui.daterangepicker.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />
		
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.ptTimeSelect.css" />
		<script type="text/javascript" src="<?php echo base_url()?>javascript/jquery.ptTimeSelect.js"></script>



    <!-- new DatePicker -->
    
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>javascript/newDatePicker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo base_url()?>javascript/newDatePicker/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%M-%Y",
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
                        */
			cellColorScheme:"blue"
                        /*
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
            
		});
	};
</script>
                
                

<script type="text/javascript">	
			$(function(){
				  $('#rangeA').daterangepicker({arrows:true}); 
			 });
                         
                         
		</script>
<?php
	/*$data = array(
               3  => 'http://example.com/news/article/2006/03/',
               7  => 'http://example.com/news/article/2006/07/',
               13 => 'http://example.com/news/article/2006/13/',
               26 => 'http://example.com/news/article/2006/26/'
             );
			 */
	
	//echo $calendarMonths;
	//echo $calendarAssign;
	
	//echo $calendar;
?>

                <!--
<input type="text" value="" id="rangeA" style="width: 150px; height: 1.2em; display:block;" title="Click me to Select Date"/>	

<input type="text" name="s1Time2" class="rangeB" style="width: 150px; height: 1.2em; display:block;" title="Click me to Select Time"/> <br/>

<div>
	<h3 class="time"> Wala pa! </h3>
</div>
                
                -->

	
<script type="text/javascript">
        $('.rangeB').click(function(){
            // find the input fields and apply the time select to them.
            //$('#rangeB').ptTimeSelect();
			//alert("ALALAH!");
			var input = $('.rangeB').val();
			var i=0;
			var am = false;
			while(input)
			{
				
				if(input[i] == 'A')
				{
					am = true;
					break;
				}
				i++;
			}
			
			/*
			if(am == true)
				alert("AM");
			else if(am == false)
				alert("PM");
				
				*/
			if(input == "")
			$('.time').text();
			else
			$('.time').text('Your time is '+input);
			//alert("laala"); 
        });
    </script>
	
<script type="text/javascript">

        $('.rangeB').change(function(){
			var input = $('.rangeB').val();
			var i=0;
			var am = false;
			while(input)
			{
				
				if(input[i] == 'A')
				{
					am = true;
					break;
				}
				i++;
			}
			
			/*
			if(am == true)
				alert("AM");
			else if(am == false)
				alert("PM");
				
				*/
			if(input == "")
			$('.time').text();
			else
			$('.time').text('Your time is '+input);
			//alert("laala");
        });
    </script>
	
    
    
   
    
    </head>

<body>
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
         
        
   <!--  Time <input name="time" type="text" class="rangeB" style="width: 150px; height: 2.2em; display:block;" title="Click me to Select Time" onclick="this.value=''" required="required"> </br> -->
    Date <input name="date" type="text" id="rangeA" style="width: 150px; height: 2.2em; display:block;" title="Click me to Select Date" onclick="this.value=''" required="required"> </br>
    <input type="hidden" id="time" name="time" value=""/>
    
    <div id="time_available">
    </div>
    
    <div id="time_reservation">
        </div>
     
   <!-- </form> -->
   <input type="submit" id="check" value="Check" onclick=""/>
   <input type="button" id="reserve" value="reserve" onclick=""/>
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
    $('#check').click(function(){
        var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $('#rangeA').val()
        };
        if(form_data['date'] == "")
        {
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
            var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $('#rangeA').val(),
            time : $('#time').val()
            };
            
            //alert(form_data['doctor_id']+form_data['date']+form_data['time']);
            if(form_data['doctor_id'] == "" || form_data['date'] == "" || form_data['time'] == null)
            {
                alert("Please fill out all the necessary information.");
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
            }
        });
</script>

