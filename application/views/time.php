<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
//print_r($time_info);

if(isset($whole_day))
{
    if($whole_day == true)
    {
        echo "The whole clinic is out this day. Please reserve another day.";
    }
    else
    {


$time_with_name = array();
if(!isset($time_end))
{
    $time_end = 20;
}
$time_available = array();
$time_not_available = array();
$time_not_available_with_hours = array();
$confirm = false;
$time_with_id = array();
for($i=$time_start;$i<=$time_end;$i++)
{
    $time_with_id[$i] = 0;
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if(isset($time_info) && is_array($time_info))
    {
        for($i=0;;$i++)
        {
            if(isset($time_info[$i]))
            {
                for($j=0;$j<$time_info[$i]['hour'];$j++)
                {
                    if($time_info[$i]['time'][0] == "0")
                    {
                        
                                $time_not_available[$i+$j] = ($time_info[$i]['time'][1])+$j;
                         
                    }
                    else
                    {
                        //for($j=0;$j<$time_info[$i]['hour'];$j++)
                            $time_not_available[$i+$j] = ($time_info[$i]['time'][0].$time_info[$i]['time'][1])+$j;
                            
                    }
                }
                //else
                    //$time_not_available[$i] = $time_info[$i]['time']['1'].$time_info[$i]['time']['2'];
            }
            if(!isset($time_info[$i+1]))
                break;
            //print_r($time_not_available);
        }
        for($i=0;$i<24;$i++)
        {
            $time_available[$i] = "ok";
        }
        for($i=0;$i<24;$i++)
        {
            if(isset($time_not_available[$i]))
            {
                $value = $time_not_available[$i];
                
                if(isset($time_info[$i]['id']))
                {
                    for($j=0;$j<$time_info[$i]['hour'];$j++)
                    {
                        $time_with_id[$value+$j] = $time_info[$i]['id'];
                        $time_available[$value+$j] = "not";
                        $time_with_name[$value+$j]['patient_info'] = $time_info[$i]['patient_info'];
                    }
                }
            }
        }
    }
    

    //print_r($time_with_id);
?>
<?php $afternoon = false; ?>
<hmtl>
    <head>
    </head>
    <body>
       
        <div style=" height: 280px; width:200px; background:url(<?php echo base_url()?>images/bg.png) repeat-x; background-size: 300px 300px">
    <center>
		<h3>TIME</h3>
		<p>
			<?php 
                        
                            
                            if(!(isset($time_info)) || !(is_array($time_info)))
                            {
                                for($i=0;$i<24;$i++)
                        {
                                ?>
                <div style="cursor: pointer; width:100px;background-color:<?php if($i%2 == 0) echo "#aaa"; else echo "white"?>"> 
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
                            </div>
                    <?php
                            }
                            }
                          else
                          {
                              for($i=0;$i<24;$i++)
                        {
                            if($i >= $time_start && $i < $time_end)
                            {
                               
                                $time_check = $time_available[$i];
                            ?>
                <div <?php if($time_check == "ok"){ ?>id='time_<?php echo $i?>' <?php } else{ ?> id="<?php echo $time_with_id[$i]; ?>" class="time_not_available"   <?php }?> style="cursor: pointer; width:100px;background-color:<?php if($i%2 == 0) echo "#aaa"; else echo "white"?>"> 
                                <?php
                                if($i<12) 
                                {
                                    $time_check = $time_available[$i];
                                    if($time_check == "ok")
                                    {
                                        echo $i.":00 AM"; 
                                    }
                                    else
                                    {
                                        
                                        if(isset($this->session->userdata['doctor_info']['id']) || isset($this->session->userdata['admin_info']['id']))
                                        {
                                            echo $time_with_name[$i]['patient_info']['first_name']." ".$time_with_name[$i]['patient_info']['last_name'];
                                        }
                                        if(isset($this->session->userdata['patient_info']['id']))
                                        {
                                            echo "My Schedule";
                                        }
                                        else
                                        {
                                            echo "RESERVED";
                                        }
                                    }
                                    
                                }
                                if($i==12)
                                {
                                     if($time_check == "ok")
                                    {
                                        echo $i.":00 PM"; 
                                    }
                                    else
                                    {
                                        echo "RESERVED";
                                    }
                                }
                                if($i>=13)
                                {
                                    $time_check = $time_available[$i];
                                    if($time_check == "ok")
                                    {
                                        echo ($i-12).':00 PM'; 
                                    }
                                    
                                    else
                                    {
                                        echo "RESERVED";
                                    }
                                    $afternoon=true;
                                }
                                
     
                                ?> 
                            </div>
                    <?php
                                
                            }
                        }
                          
                        }
                        ?>
		</p>
                </center>
</div>
  
        </body>
        </html>
        
      <script type="text/javascript">
         <?php
         
         for($i=0;$i<24;$i++)
         {
         ?>
             
             $('#time_<?php echo $i?>').click(function(){
                 //alert("adgdfhgjhkgj");
                 var time = '<?php if($i<12){ echo $i.':00 AM';} elseif($i==12){echo $i.':00 PM';} else {echo ($i-12).':00 PM';}?>';
                 var date = $('#rangeA').val();
                 //alert(date);
                 $('#time_reservation').html("Time is: "+time);
                 $('#time_reservation_for_admin').html("Time is: "+time);
                 //alert(time);
                 $('#time').val(time);
                 $('#time_for_admin').val(time);
       
            });
         <?php
         }

         ?>
         
         </script>
         
         
     <script type="text/javascript">
         $('.time_not_available').click(function(){
             //alert('asdhg');
      <?php if(isset($this->session->userdata['doctor_info']['id']))
                    {
              ?>
//                      alert(this.id);
//                        var form_data = {
//                        reservation_id : this.id
//                            };
//                        $.ajax({
//                            url:"<?php echo base_url();?>doctor-reschedule-reservation",
//                            type: 'POST',
//                            data: form_data,
//                            success: function(msg){
//                                $('#time_available_main').html(msg);
//                               //alert(msg);
//                            }
//                        })
//                    $('#click_to_load').bind('click',function(){
//                        $('#click_to_load').html('<h3>Back to My Schedule</h3>')
//                    });
                   //$('#click_to_load').html('Back to My Schedule');
                    $('#form_reschedule').show('slow');
                    $('#my_schedule').html('');
                    $('#reservation_id').val(this.id);
                   
                    //alert($('#reservation_id').val());
                   
             <?php
                    }
                    else
                    {
             ?>
            alert("NOT AVAILABLE"); 
            <?php }
            ?>
         });
     </script>
     
     
<?php }}?>
     
     
     
     