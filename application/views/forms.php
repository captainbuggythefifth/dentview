<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>
<div id="log_in" style="">
    
    <div class="header_lg">
		<h3 style="margin: 20px 0px 15px 10px">Log in</h3>
                <hr/>
		<!--<form method="POST" action="<?php echo base_url();?>patient-log-in-validate"> -->
    <?php echo form_open('patient-log-in-validate'); ?>
    <?php 
    $patient_info = array(
            'email_add' => 'email_add',
            'password'  => 'password',
    );
?>
    <div class="inpt">
        
    <div style="float: left; padding:5px;"> <span class="eml"><input id="email_add_log_in"type="text" required ="require" value="Email Address" onclick="this.value=''" name="email_add" class="eml"/></span></div><br/>
        <div class="patient_exist_image" style="display: none; float: right; padding-top: 1px; margin: -5px 0 0 220px; position: fixed"><img src="<?php echo base_url()?>images/wrong.jpg" style="width: 20px; height: 20px;"> <p style="margin: -18px 0 0 23px;">Please do register.</p></div>
        <div class="patient_does_not_exist_image" style="display: none; float: right; padding-top: 1px; margin: -5px 0 0 220px; position: fixed"><img src="<?php echo base_url()?>images/right.jpg" style="width: 20px; height: 20px;"></div>
    <div style="float: left"> <span class="pswd"><input type="password" name="password" value="Password" required ="require" onclick="this.value=''" class="pswd"/></span>
        
        <span style=" float: left; padding-top: 25px; margin-left: 29px;"><div id="patient_confirmation" style="display: none;"> </div></span>
    </div>
    </div><br/><br/>
          <div style="float: left; margin-left: -180px"><a href="#div_forgot_password" class="forgot_password">Forgot your password?</a></div>
    </div>
          <?php if(isset($_GET['msg']))
    {
            //$msg = $this->encrypt->decode($_GET['msg']);
        $msg = $_GET['msg'];
        if($msg == "pdnm")
        {
            echo "<div style=' float: left; color:#f00; text-align:center; height: 15px; padding:5px; position:relative; margin: 20px 50px; font-weight:bold;'>
			Password did not match</div>";
        }
        elseif($msg == "cidnm")
        {
            echo "<div id='con_id' style='float: left; color:#f00; text-align:center; height: 15px; padding:5px; position:relative; margin: 20px 35px; font-weight:bold;'>
			Confirmation id did not match</div>";
        }
            
    }
        ?>
    
               <input disabled type="submit" value="Log in" class="logbtn" id="log_in_button">
          <!--</form> -->
          <?php echo form_close()?>
          
  </div>
	
<script>
    $('#log_in_button').click(function(){
        //alert('Password'+$('#password_log_in').val());
    })
</script>
<div id="sign_up" style="width: 350; height: 550">
<H3>SIGN-UP</H3>



<?php

    if(isset($msg))
    {
        echo $msg;
        unset($msg);
    }
    if(isset($_GET['msg']))
    {
        if($_GET['msg'] == "swwdr")
        {
            echo "Something went wrong during the registration. Please do sign up again.";
        }
    }
?>
<?php echo form_open('patient/sign_up_validate',"id = 'sign_up_form' name='myForms'"); ?>
<?php 
    $patient_info = array(
            'first_name' => 'first_name',
            'mi' => 'mi',
            'last_name' => 'last_name',
            'email_add' => 'email_add',
            'password'  => 'password',
            'address' => 'address',
            'mobile_number' => "mobile_number",
            'age' => 'age',
            'gender' => 'gender',
            'marital_status' => 'marital_status',
            'occupation' => 'occupation'
    );
?>
<fieldset>
<legend> Log In Information </legend>
<input id="email_add_hidden" type="hidden" value=""/>
Email Address: <span class="eml_add"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="email_add"
                       id ="email_add"
                       class="eml_add"
                       onclick="this.value=''"
                       value =""/></span>
                <div class="patient_exist_image" style="display: none; float: right; margin-left:0px; padding-top: 2px;"><img src="<?php echo base_url()?>images/wrong.jpg" style="width: 20px" title="This email address already exist. Please try again new."></div>
                <div class="patient_does_not_exist_image" style="display: none; float: right; margin-left: 0px; padding-top: 2px;"><img src="<?php echo base_url()?>images/right.jpg" style="width: 20px" title="fadsf"></div>

                <br/>
                
Password: <span class="pss"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="password"
                       name ="password"
                       id ="password"
                       class="pss"
                       required ="require"
                       value =""
                       /></span>
                <br/>
Retype Password: <span class="pss2"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="password"
                       
                       id ="retype_password"
                       class="pss2"
                       required ="require"
                       value =""
                       /></span>
                <br/>
</fieldset> </br> </br>
<fieldset>
<legend> Personal Information </legend>

First Name: <span class="fname"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="first_name"
                       id ="first_name"
                       class="fname"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['first_name']?>"/></span>
                <br/>
Middle Initial: <span class="mi"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="mi"
                       id ="mi"
                       class="mi"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['mi']?>"/></span>
                <br/>

Last Name: <span class="lname"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="last_name"
                       id ="last_name"
                       class="lname"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['last_name']?>"/></span>
                <br/>

Mobile Number: <span class ="mobile"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="mobile_number"
                       id ="mobile_number"
                       class ="mobile"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['address']?>"/></span> </br>
                

                
Address: <span class="addrss"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="address"
                       id ="address"
                       class="addrss"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['address']?>"/></span> </br>
                

Age: <span class="age"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="age"
                       id ="age"
                       class="age"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['address']?>"/></span> </br>
                
Gender: <?php //echo form_input($patient_info['first_name']);?> 
                <select
                       name ="gender"
                       id ="gender"
                       class="gender"
                       required ="require"
                       >
                    <option value="Male"> Male </option>
                    <option value="Female"> Female </option>
                    
                </select>
                    </br>
Occupation: <span class="occupation"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="occupation"
                       id ="occupation"
                       class="occupation"
                       required ="require"
                       value =""/></span> </br>
                

Status: <?php //echo form_input($patient_info['first_name']);?> 
                <select
                       name ="marital_status"
                       id ="marital_status"
                       class="status"
                       required ="require"
                       >
                    <option value="Single"> Single </option>
                    <option value="Married"> Married </option>
                    
                </select>
                    </br>

</fieldset>

<fieldset>
<input type="hidden" id="secure_all_fields" value="not">
<div id="draggable" style="width: 70; height: 70; float: left; display: inline; padding: 0;"><img src="<?php echo base_url()?>images/icon.png" style="width: 70; height: 75"></div>
<div id="droppable" style="width: 70; height: 70; float: right; border: 1px solid #3CC; padding:3px;">
	<p>Drop the tooth here to activate registration</p>
</div>
</fieldset>
<!-- <input type='submit' id="sign_up_button" name='submit' class='reg' value ='Register' disabled/> -->
<?php  echo form_close();?>
<div class="errors" style="display: none; border-color: #cd0a0a; color: red">There are illegal letters found in your fields.</div>


</div>
<script>
    $('#mobile_number').change(function(){
        var x = $('#mobile_number').val();
        
    })
    
</script>
<script>
    $('#email_add_log_in').change(function(){
        var x=$(this).val();
        var atpos=x.indexOf("@");
        var dotpos=x.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
        {
          //$('#image_for_email').hmtl("OK"); 
          alert("This "+ x +" email address is not valid");
        }
        else{
        var form_data = {
           email_add : $(this).val(),
           is_from_ajax : 1
        }
        $.ajax({
                    url:"<?php echo base_url();?>patient/log_in_validate",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#loader').html(msg);
                        if(msg == false){
                            //$('#log_in_button').hide('fast');
                            
                            document.getElementById('log_in_button').disabled = true;
                            $('.patient_does_not_exist_image').hide('fast');
                            $('.patient_exist_image').show('fast');
                            $('#patient_confirmation').hide('slow');
                            
                        }
                        else if(msg == true){
                            document.getElementById('log_in_button').disabled = false;
                            $('.patient_exist_image').hide('fast');
                            $('.patient_does_not_exist_image').show('fast');
                            $('#patient_confirmation').hide('slow');
                        }
                        else{
                            document.getElementById('log_in_button').disabled = false;
                            $('#patient_confirmation').html(msg);
                            $('#patient_confirmation').show('slow');
                            //alert(msg);
                            //$('.patient_exist_image').hide('fast');
                            //$('.patient_does_not_exist_image').show('fast');
                        }
                    //alert(msg);
                    //alert("\nalalallaj!");
                    }
                })
                }
    });
</script>


<script>
    $('#email_add').change(function(){
        var x=$(this).val();
        var atpos=x.indexOf("@");
        var dotpos=x.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
        {
          //$('#image_for_email').hmtl("OK"); 
          alert("This "+ x +" email address is not valid");
        }
        else if(x == '')
        {
            //alert('sasdfgdgs');
            $('.patient_does_not_exist_image').show('fast');
            $('.patient_exist_image').show('fast');
            $('#email_add_hidden').val('not');
        }
        else
        {
            var form_data = {
               email_add : $(this).val(),
               is_from_ajax : 1
            }
            $.ajax({
                        url:"<?php echo base_url();?>patient/sign_up_validate",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                            if(msg == true){
                                $('.patient_does_not_exist_image').hide('fast');
                                $('.patient_exist_image').show('fast');
                                $('#email_add_hidden').val('not');
                                //alert($('#email_add_hidden').val());
                                //document.getElementById('password').disabled = false;
                            }
                            else if(msg == false){
                                $('.patient_exist_image').hide('fast');
                                $('.patient_does_not_exist_image').show('fast');
                                $('#email_add_hidden').val('ok');
                                //alert($('#email_add_hidden').val());
                                
                                //document.getElementById('password').disabled = false;
                            }
                            //alert(msg);
                        }
            })
        }
    });
</script>

<script>
    $('#password').change(function(){
        var confirm = form_validate(document.myForms.password);
        if(confirm == false)
        {
            //$('#')
            document.getElementById("first_name").disabled=true;
            this.value="";
        }
        else
        {
            document.getElementById("first_name").disabled=false;
        }
    });
    
    $('#first_name').change(function(){
        var confirm = form_validate(document.myForms.first_name);
        if(confirm == false)
        {
            //$('#')
            document.getElementById("mi").disabled=true;
            this.value="";
        }
        else
        {
            document.getElementById("mi").disabled=false;
        }
    });
    
    $('#mi').change(function(){
        var confirm = form_validate(document.myForms.mi);
        if(confirm == false)
        {
            //$('#')
            document.getElementById("last_name").disabled=true;
            this.value="";
        }
        else
        {
            document.getElementById("last_name").disabled=false;
        }
    });
    
    $('#last_name').change(function(){
        var confirm = form_validate(document.myForms.last_name);
        if(confirm == false)
        {
            //$('#')
            document.getElementById("mobile_number").disabled=true;
            this.value="";
        }
        else
        {
            document.getElementById("mobile_number").disabled=false;
        }
    });
    
    $('#mobile_number').change(function(){
        var confirm = form_validate(document.myForms.mobile_number);
        if(confirm == false)
        {
            //$('#')
            document.getElementById("address").disabled=true;
            this.value="";
        }
        else
        {
            document.getElementById("address").disabled=false;
        }
    });
    
    $('#address').change(function(){
        var confirm = form_validate(document.myForms.address);
        if(confirm == false)
        {
            //$('#')
            //document.getElementById("address").disabled=true;
            document.getElementById("age").disabled=true;
            this.value="";
            //$('#secure_all_fields').val("not");
        }
        else
        {
            //document.getElementById("address").disabled=false;
            document.getElementById("age").disabled=false;
        }
    });
    
    
    $('#age').change(function(){
        var confirm = form_validate(document.myForms.age);
        if(confirm == false)
        {
            //$('#')
            document.getElementById("occupation").disabled=true;
            this.value="";
        }
        else
        {
            document.getElementById("occupation").disabled=false;
        }
    });
    
    
    $('#occupation').keyup(function(){
        var confirm = form_validate(document.myForms.occupation);
        if(confirm == false)
        {
            //$('#')
            //document.getElementById("occupation").disabled=true;
            $('#secure_all_fields').val("not");
            this.value="";
        }
        else
        {
            //document.getElementById("address").disabled=false;
            $('#secure_all_fields').val("ok");
        }
    });
    
    
    /*
    
    $('#address').keydown(function(){
        var confirm = form_validate(document.myForms.address);
        if(confirm == false)
        {
            //$('#')
            //document.getElementById("address").disabled=true;
            this.value="";
            $('#secure_all_fields').val("not");
        }
        else
        {
            //document.getElementById("address").disabled=false;
            $('#secure_all_fields').val("ok");
        }
    });
    */
</script>
<script>
    $('#mobile_number').change(function(){
        var num = $(this).val();
        var str = /[a-z\A-Z]/;
        if(str.test(num) || num.length != 11 || num == ""){
            alert('Invalid mobile number');
            $('#mobile_number').val('');
        }
        
    })
</script>

<script>
    $('#age').change(function(){
        var num = $(this).val();
        var str = /[a-z\A-Z]/;
        if(str.test(num) || num.length > 2 || num == ""){
            alert('Invalid age');
            $('#age').val('');
        }
    })
</script>

<script>
    $('#retype_password').change(function(){
        var retype = $(this).val();
        var pass = $('#password').val();
        if(pass != retype)
            {
                alert("Retyped password does not match the first one. Please do type again"); 
                $(this).val("");
                $('#password').val("");
            }
    })
</script>

<div id="div_forgot_password" style="display: none; width: 400px; height: 200px">
<div class="bg_table" style="padding:10px; height:170px;"><br />
    We just need a little information from you. :D
    <div class="p_adjust"></div>
    <div style="margin-left: 10px">Email Address : <span style="margin-left:17px; padding-left:2px;"><input type="text" id="forgot_password_email_add"><a style="color: red; font-size: 50px; margin-top: -7px; margin-left: 8px; position: absolute">*</a></span></div>
    <div style='margin-left: 10px'>Mobile Number : <span style="margin-left:14px; padding-left:2px;"><input type='text' id='forgot_password_mobile_number'><a style="color: red; font-size: 50px; margin-top: -5px; margin-left: 8px; position: absolute">*</a></span></div>
    <div id="patient_profile" style="display: none">
        <br/>
    </div>
</div>
</div>
<script>
    $('#forgot_password_email_add').change(function(){
        $('#patient_profile').slideUp('slow');
        var form_data = {
            email_add : $(this).val().trim()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>patient/forgot_password",
            type: "POST",
            data : form_data,
            success : function(msg){
                $('#patient_profile').html(msg);
                $('#patient_profile').show('fast');
                $('#patient_profile').slideDown('slow');
            }
        })
    })
</script>

