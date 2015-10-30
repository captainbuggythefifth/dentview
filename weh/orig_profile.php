
<?php
    $link_for_reserve = '#link_for_reserve';
    if(isset($this->session->userdata['patient_info']['id']))
    {
        //$link_for_reserve = base_url().'patient-reservation';
        $link_for_reserve = '#link_load_reservation';
    }
?>
<body>


<?php
//print_r($this->session->userdata['patient_info']);
if(isset($is_edited) && $is_edited == true)
{
    echo "<script> alert('Your profile has been successfully updated!'); </script>";
    $is_edited = false;
}
if(isset($msg))
{
    echo $msg;
    //print_r($patient_info);
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    if(isset($this->session->userdata['patient_info']['id']))
    {
        
        
?>
    Welcome <?php echo $this->session->userdata['patient_info']['first_name']?> </br>
    <div id="form_loader">Edit My Profile</div>
<?php
    }
    else
    {
        //redirect(base_url());
        redirect(base_url());
    }
?>
    <div id="load"> 
        <div id="profile_div">
            <img src="<?php echo $this->session->userdata['patient_info']['photo_info']['source']?>">
            First Name: <?php echo $this->session->userdata['patient_info']['first_name']?> </br>
            Last Name: <?php echo $this->session->userdata['patient_info']['last_name']?> </br>
            MI: <?php echo $this->session->userdata['patient_info']['mi']?> </br>
            Email Address: <?php echo $this->session->userdata['patient_info']['email_add']?> </br>
        </div>
        
        <div id="reservation_div">
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
                ?>
        </div>
     </div>
    
    
    <?php if(isset($error))echo $error;?>



<?  echo validation_errors('<p class="errors">')?>


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
<? echo form_open('patient/profile_edit'); ?>
<?php 
    $pass = $this->encrypt->decode($this->session->userdata['patient_info']['password']);
    $patient = array(
            'first_name' => 'first_name',
            'mi' => 'mi',
            'last_name' => 'last_name',
            'email_add' => 'email_add',
            'password'  => 'password',
            'address' => 'address'
    );
?>

    
    First Name: <input type='text' name='first_name' value='<?php echo $this->session->userdata['patient_info']['first_name']?>'> </br>
    Middle Initial: <input type='text' name='mi' value='<?php echo $this->session->userdata['patient_info']['mi']?>'> </br>
    Last Name: <input type='text' name='last_name'value='<?php echo $this->session->userdata['patient_info']['last_name']?>'> </br>
    Email Address: <input type='text' name='email_add' value='<?php echo $this->session->userdata['patient_info']['email_add']?>'> </br>
    Address: <input type='text' name='address' value='<?php echo $this->session->userdata['patient_info']['address']?>'> </br>
    Password: <input type='text' name='password' value='<?php echo $pass?>'> </br>
    
    <input type="submit" name="submit" value ="Register"/>
    
    
    <?  echo form_close();?>
    
    
    <?php echo form_open_multipart('patient/upload',"id='uploader'");?>
    
    

    <input type="file" name="userfile" size="20" id="upload_file"/>

    <br /><br />
    <div id="look"> LOOOOKKKK </div>
    <input type="submit" value="upload" />

    </form>
    
    
</div>
	</div>
 
 <li><a class="fancybox" href="#inline1" title="Profile Edit">Edit My Profile</a></li>
 <li><a class="fancybox fancybox.ajax" href="<?php echo base_url()?>weh/reservation.php">Ajax</a></li>
 <?php if(isset($this->session->userdata['patient_info']['reservation_info']))
        {
            if(count($this->session->userdata['patient_info']['reservation_info']) > 0)
            {
 ?>
 <li><a id="fancybox_reserve" href="<?php echo $link_for_reserve ?>">Reschedule</a></li>
 
 <?php 
            }
        }
 
 ?>
 
 <input type="text" id="date">
 
 <script>
    $(function() {
    $( "#date" ).datepicker({});
  });
</script>

               


    
   </body> 

 <div id="link_load_reservation" style="height:400; width:400px;display: none;">
    <div style="height:100;"><div id="click_to_load"><center><h3>RESCHEDULE</h3></center></div></div>
    <div id="img_loader" style="display: none;"> <img src="<?php base_url()?>images/loading.gif" style="height: 20;width: 20"> </div>
    <div id="loader"> </div>
    
</div>   
<script> 
    $('#look').click(function(){
        
          //  alert($('#uploader').data());
        var form_data = {
            upload_data : $('#uploader').data()
            };
        
        $.ajax({
                    url:"<?php echo base_url();?>patient/photo_preview",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#success').html(msg);
                    alert(msg);
                    }
                })
    }); 
</script>

<script>
    $('#form_loader').toggle(
    function(){
        //$('#form_div').append("<div id='forms'> <a href='#' id='form_hide'>HIDE ME!</a> First Name: <input type='text' value='<?php echo $patient_info['first_name']?>'> </br>Last Name: <input type='text' value='<?php echo $patient_info['last_name']?>'> </br>Email Address: <input type='text' value='<?php echo $patient_info['email_add']?>'> </br>Address: <input type='text' value='<?php echo $patient_info['address']?>'> </br>Password: <input type='text' value='<?php echo $patient_info['password']?>'></div>");
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
    $('#click_to_load').live('click',function(){
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
</script>


<script>
    $('#loader').ajaxComplete(function(){
        $('#img_loader').hide();
    });
</script>
