<?php

$time_start = 8;
$time_end = 20;
$time_available = array();
$time_not_available = array();
$confirm = false;
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
                if($time_info[$i]['time'][0] == "0")
                    $time_not_available[$i] = $time_info[$i]['time'][1];
                else
                {
                    $time_not_available[$i] = $time_info[$i]['time'][0].$time_info[$i]['time'][1];
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
                $time_available[$value] = "not";
            }
        }
    }
    
?>
<?php $afternoon = false; ?>
<hmtl>
    <head>
    </head>
    <body>
       
<div id="inline1" style="width:1000px;">
		<h3>TIME</h3>
		<p>
			<?php 
                        
                            
                            if(!(isset($time_info)) || !(is_array($time_info)))
                            {
                                for($i=0;$i<24;$i++)
                        {
                                ?>
                <div style="width:100px;background-color:<?php if($i%2 == 0) echo "#aaa"; else echo "white"?>"> 
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
                <div <?php if($time_check == "ok"){ ?>id="time_<?php echo $i?>" <?php } else{ ?> class="time_not_available" <?php }?> style="width:100px;background-color:<?php if($i%2 == 0) echo "#aaa"; else echo "white"?>"> 
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
                                        echo "RESERVED";
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
</div>
  
        </body>
        </html>
     <script type="text/javascript">
         $('.time_not_available').click(function(){
            alert("NOT AVAILABLE"); 
         });
     </script>
     <script type="text/javascript">
         <?php
         for($i=0;$i<24;$i++)
         {
         ?>
             
             $('#time_<?php echo $i?>').click(function(){
                 
                 var time = '<?php if($i<12){ echo $i.':00 AM';} elseif($i==12){echo $i.':00 PM';} else {echo ($i-12).':00 PM';}?>';
                 var date = $('#rangeA').val();
                 //alert(date);
                 $('#time_reservation').html("Time reserved is: "+time);
                 $('#time').val(time);
       
            });
         <?php
         }
         ?>
         
         </script>