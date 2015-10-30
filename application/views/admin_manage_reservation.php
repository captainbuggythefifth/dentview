<?php
    if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>

<script>
    $(function() {
    $("#date_reschedule").datepicker({});
  });
</script>

<script>
    $(document).ready(function(){
        document.getElementById("reservation_link").style.backgroundColor="#FFF";
        document.getElementById("reservation_link").style.padding="7px 15px 7px 73px";
    })
</script>
<div style="border:1px solid #ccc; background:#EFEFEF; height:40px; border-bottom:none; width:auto;"><h4 style=" margin: 10px 15px; float:left;">Reservation&nbsp;&nbsp;|   </h4>
<a href="#div_reserve" id="fancybox_reserve" class="add_patient" style="margin:5px 0;">Make a reservation</a><br />
<div id="div_reserve" style="display: none; width: 330; height: 380">
<div style="border:1px solid #ccc; background:#F1F5FA;  padding:5px;">
    <?php
    if(isset($patient_active))
    {
       
        //print_r($reservation_active_info);
        if(count($patient_active) > 0 && is_array($patient_active))
        {
            ?>
            <select>
            <?php
            foreach($patient_active as $patient_info)
            {
                $reserved_info = $this->reservation_model->get_reserved($patient_info['id']);
                if(!is_array($reserved_info) || count($reserved_info) < 1)
                {
                    ?>
                    <option value="<?php echo $patient_info['id']?>"><?php echo $patient_info['first_name']." ".$patient_info['last_name']?></option>
                    <?php
                }
                
            }
            ?>
            </select>
    
    		
            <div id="div_patient_info" style="background:#FBFBFB; height:53px; padding:5px; border-bottom:1px solid #ccc; border-top:1px solid #ccc; margin-top:10px;">
                <img src="<?php echo base_url().$patient_active[0]['photo_info']['source']?>" style='width:50; height:50; float:left; border:1px solid #ccc; margin-right: 10px;' >
               <div > Email : <?php echo $patient_active[0]['email_add']?> </br>
                	  Mobile Number : <?php echo $patient_active[0]['mobile_number']?></div>
            </div>
   	
            <div id="link_load_reservation">
                <!-- <div id="click_to_load"><center><h3><?php echo "Reserve"; ?></h3></center></div> -->
                <div id="img_loader" style="display: none;"> <img src="<?php base_url()?>images/loading.gif" style="height: 20;width: 20"> </div>
                <div id="loader"> </div>
                <div id="form_reschedule">
                    Date:
                        <input type="text" id="date" style="margin-bottom:10px;"/>
                        <input type="hidden" id="time"/>
                    
                    <?php
                        
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
         <div id="div_doctor_loader" style="width:300">
         <div align="left" style="width: 100;"><br />
         Select Doctor: <select id="doctor_id" name="doctor_id" title="Click me to Select Doctor">
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
          </div>
         Not available? Please specify: <input type="text" id="specified_service">
          <div align="left" id="doctor_expertise" style="width: 300"></div>
          
          
                      </div>
                    <div id="time_available" align="center"> </div>
                    <div id="time_reservation"> </div>
                    <div id="success"> </div>
                </div>

            </div>
            <a id="reserve_or_reschedule" class="doc_view_btn" href="#"><?php echo "Reserve"; ?></a><br /><br />
                <?php
        }
    }
    ?>

</div>
</div>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$datestring = "%m %Y";
        $time = time();

        $month = mdate($datestring, $time);
        $time_start = $month[0].$month[1];
        $time_str = strtotime("2013-".($month[0].$month[1]));
        $month_now = date("F Y", $time_str);
        
        $year_now = date("Y", time());
       
    ?><div class="admin_box3" style="border-top:1px solid #ccc;"><br/><br/>
Filter active reservations : 
        <select id="select_year_active_reservation">
            <?php
            for($i=2010;$i<2020;$i++)
            {
                $date_str = strtotime("2013-".$i);
                ?>
                    <option value="<?php echo $i?>" <?php if($year_now == $i) echo "selected"?>>
                        <?php echo $i?>
                    </option>

                <?php
            }
        ?>
        </select>
        <select id="select_month_active_reservation">
            <option value="1"> January </option>
            <option value="2"> February </option>
            <option value="3"> March </option>
            <option value="4"> April </option>
            <option value="5"> May </option>
            <option value="6"> June </option>
            <option value="7"> July </option>
            <option value="8"> August </option>
            <option value="9"> September </option>
            <option value="10"> October </option>
            <option value="11"> November </option>
            <option value="12"> December </option>
            
        </select></br>
        
<?php

    if(isset($reservation_active_info))
    {
        //echo $month_now;
        ?>
        
        </br>
        
        <fieldset id="field_for_active"> <legend> Active Reservation</legend>
        <?php
        $i=0;
        
        if(is_array($reservation_active_info) && count($reservation_active_info) > 0)
        {
            foreach($reservation_active_info as $reservation_active)
            {
                ?>
                <div id="admin_resrv" style=" border:1px solid #0F0; background-color: <?php if($i%2 == 0) {echo '#CFC';} else {echo '#CFF';}?> " >
                <div class="admin_res_dctr">Doctor : <?php echo $reservation_active['doctor_info']['first_name']." ".$reservation_active['doctor_info']['last_name']?></div>
                <div class="admin_res_p">Patient : <?php echo $reservation_active['patient_info']['first_name']." ".$reservation_active['patient_info']['last_name']?></div>
                <div class="admin_res_d">Date : <?php echo date_format(date_create($reservation_active['date']),"F d, Y")?></div>
                <div class="admin_res_t">Time : <?php 
                $time = $reservation_active['time'][0].$reservation_active['time'][1];
                            if($time<=11)
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
                </div>&nbsp; <a href="#div_reschedule" class="fancybox" id="<?php echo $reservation_active['id']?>">Reschedule</a>
                <input type="hidden" id="input_reservation_id" value="">
                </div>
                
                </br>
            <?php
                $i++;
            }
            
        }
        else
        {
            echo "There are no active reservations";
        }
        ?>
        </fieldset>
            <?php
    }
    
        $datestring = "%m %Y";
        $time = time();

        $month = mdate($datestring, $time);
        $time_start = $month[0].$month[1];
        $time_str = strtotime("2013-".($month[0].$month[1]));
        $month_now = date("F Y", $time_str);
        ?>
        
        <br/><br/>
Filter inactive reservations : 
        <select id="select_year_inactive_reservation">
            <?php
            //for($i=2013;$i<2020;$i++)
            for($i=2010;$i<2020;$i++)
            {
                $date_str = strtotime("2013-".$i);
                ?>
                    <option value="<?php echo $i?>" <?php if($year_now == $i) echo "selected"?>>
                        <?php echo $i?>
                    </option>

                <?php
            }
        ?>
        </select>
        <select id="select_month_inactive_reservation">
         <option value="1"> January </option>
            <option value="2"> February </option>
            <option value="3"> March </option>
            <option value="4"> April </option>
            <option value="5"> May </option>
            <option value="6"> June </option>
            <option value="7"> July </option>
            <option value="8"> August </option>
            <option value="9"> September </option>
            <option value="10"> October </option>
            <option value="11"> November </option>
            <option value="12"> December </option>
            
        </select></br>
        
        <?php
    if(isset($reservation_inactive_info))
    {
       // print_r($reservation_inactive_info);
        //print_r($reservation_active_info);
        
           
        ?>
        <fieldset id="field_for_inactive"> <legend> Latest inactive reservation</legend>
        <?php
        $i=0;
        //$first = $reservation_inactive_info[0]['date'][8].$reservation_inactive_info[0]['date'][9];
        //$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
        
        //echo $first;
        if(isset($reservation_inactive_info) && is_array($reservation_inactive_info) && count($reservation_inactive_info) > 0)
        {
        foreach($reservation_inactive_info as $reservation_inactive)
        {
            
            ?>
            <div id="admin_resrv" style=" border:1px solid #F90; background-color: <?php if($i%2 == 0) echo '#FF9'; else echo '#FF9';?>">
            <div class="admin_res_dctr">Doctor : <?php echo $reservation_inactive['doctor_info']['first_name']." ".$reservation_inactive['doctor_info']['last_name']?></div>
            <div class="admin_res_p">Patient : <?php echo $reservation_inactive['patient_info']['first_name']." ".$reservation_inactive['patient_info']['last_name']?></div> 
            <div class="admin_res_d">Date : <?php echo date_format(date_create($reservation_inactive['date']),"F d, Y");?></div>
            <div class="admin_res_t">Time : <?php 
                                                //$reservation_inactive['time'];
                                                $time = $reservation_inactive['time'][0].$reservation_inactive['time'][1];
                            if($time<=11)
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
                                            ?></div>
            </div>
            <br/>
            </br>
        <?php
        }
        }
        ?>
        
        </fieldset>
        <?php
    }
    
?>
</div>
<div id="div_reschedule" style="display: none; width: 300; height: 300"> 
    Date : <input type="text" id="date_reschedule"> 
    <div id="time_avail"> </div>
    <div id="time_reservation_for_admin"></div>
    <input type="hidden" id="time_for_admin" value="">
    <div id="success"></div>
    <a href="#" id="button_reschedule" class="rsrv_btn">Reschedule</a>
</div>
<script>
    $('.fancybox').click(function(){
        $('#input_reservation_id').val(this.id);
    })
</script>

<script>
    $("select").change(function () {
        var form_data = {
            patient_id : $(this).val()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/preview",
            type : "POST",
            data : form_data,
            success : function(msg){
                //alert(msg);
                $('#div_patient_info').html(msg);
            }
        })
    })
</script>

<script>
    $(function() {
    $( "#date" ).datepicker({});
  });
</script>

<script>
    $('#click_to_load').click(function(){
        $('#form_reschedule').fadeIn('slow');
        $('#my_schedule').fadeOut('slow');
    });
</script>


<script type="text/javascript">
    $('#date').live('change',function(){
        //alert($(this).val());
        var day = new Date($(this).val());
        
        //alert(date.getDay());
        //$('#img_loader').show(10);
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
    });
    function func(){
        //alert("alalaalla");
        var day = new Date($("#date").val());
        var form_data = {
            doctor_id : $('#doctor_id').val(),
            date : $("#date").val(),
            day : day.getDay()

        };
        $.ajax({
            url:"<?php echo base_url(); ?>admin/reserve",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#time_available').html(msg);
                //alert("aalalal");
            }
        })
    }
    
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
$('#reserve_or_reschedule').click(function(){
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
                date : $('#date').val(),
                time : $('#time').val(),
                hour : i,
                service_id : service_id,
                specified_service : $('#specified_service').val(),
                reservation_id : $('#reservation_id').val(),
                patient_id : $('select').val()
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
                        url:"<?php echo base_url();?>admin/reserve",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                        $('#success').html(msg);
                        }
                    })
                 }
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
    $('#doctor_id').live('change',function(){
        
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
                    noty({type:"notification",text:msg});
                    window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
                    //alert("asfsdgsgs");
                }
            })
        }
    })
</script>

<script>
    $('#select_year_inactive_reservation').change(function(){
        var form_data = {
            year_month : $(this).val()+"-"+$('#select_month_inactive_reservation').val()
        }
        //alert(form_data['month_year']);
        $.ajax({
                url : "<?php echo base_url()?>admin/reservation_inactive_look_month_year",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('#field_for_inactive').html(msg);
                }
            })
    })
</script>

<script>
    $('#select_month_inactive_reservation').change(function(){
        var form_data = {
            year_month : $('#select_year_inactive_reservation').val()+"-"+$(this).val()
        }
        //alert(form_data['month_year']);
        $.ajax({
                url : "<?php echo base_url()?>admin/reservation_inactive_look_month_year",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('#field_for_inactive').html(msg);
                }
            })
    })
</script>

<script>
    $('#select_year_active_reservation').change(function(){
        var form_data = {
            year_month : $(this).val()+"-"+$('#select_month_active_reservation').val()
        }
        //alert(form_data['month_year']);
        $.ajax({
                url : "<?php echo base_url()?>admin/reservation_active_look_month_year",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('#field_for_active').html(msg);
                }
            })
    })
</script>

<script>
    $('#select_month_active_reservation').change(function(){
        var form_data = {
            year_month : $('#select_year_active_reservation').val()+"-"+$(this).val()
        }
        //alert(form_data['month_year']);
        $.ajax({
                url : "<?php echo base_url()?>admin/reservation_active_look_month_year",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('#field_for_active').html(msg);
                }
            })
    })
</script>