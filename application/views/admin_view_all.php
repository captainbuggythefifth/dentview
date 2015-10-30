<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>
<script>
    $(document).ready(function(){
        document.getElementById("admin_link").style.backgroundColor="#FFF";
        document.getElementById("admin_link").style.padding="7px 15px 7px 73px";
    })
</script>

<?php
    if(isset($admins))
    {
        ?>
       
         <div style="border:1px solid #ccc; background:#EFEFEF; height:40px; border-bottom:none; width: auto;"><h4 style=" margin: 10px 15px; float:left;">Administer&nbsp;&nbsp;|   </h4>
        <a class='fancybox add_admin' id='add_admin' href='#admin_sign_up' style="margin:5px 0;">Add admin</a></div>
        
    <div id="admin_table">
        	<div class="admin_table2">
<?php
        foreach($admins as $admin)
        {
            ?>
        <ul>
        	<img src="<?php echo base_url(); ?>images/icon/smile.png" title="smile lng gd" width="40px" height="40px" style="float:left;"/>
            <div style=" float:left;"><?php echo $admin['first_name']." ".$admin['last_name'] ?></div><br />
            <li><a href="#div_admin_edit" class="admin_edit" name="<?php echo $admin['id']?>">Edit</a></li> 
            <?php if($admin['status'] == "ACTIVE")
                {
                
            ?>
               <li><a style="cursor: pointer" class="admin_deactivate" name="<?php echo $admin['id']?>">Deactivate</a></li>
   
            <?php
                }
                else
                {
                    ?>
                <li><a style="cursor: pointer" class="admin_activate" name="<?php echo $admin['id']?>">Activate</a></li>
          
                <?php
                    
                }
				?>
                </ul>
                <?php
               
        }
        ?>
        
        <div id="div_admin_edit" style="display: none; width: 280; height: 200"></div>
        <?php
       
    }
?>
	</div> 
</div>
           
        <?php
    if(isset($admins))
    {
        ?>
         <div id="admin_sign_up" style="display: none; width: 350; height: 350">
        <div class="bg_table" style="height:360px; padding:5px;"><h3 style="color:#069; margin-left:10px;">Add Admin: </h3>

        <?php //echo form_open('admin/sign_up_validate'); ?>
<?php 
    $patient_info = array(
            'first_name' => 'first_name',
            'mi' => 'mi',
            'last_name' => 'last_name',
            //'mobile_number' => 'mobile_number',
            'email_add' => 'email_add',
            'password'  => 'password',
            'address' => 'address',
    );
?>
<fieldset>
<legend> Log In Information </legend>
<input id="email_add_hidden" type="hidden" value=""/>
Email Address: <span class="add_emladd"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="email_add"
                       id ="email_add"
                       onclick="this.value=''"
                       value =""/></span>
                <div class="patient_exist_image" style="display: none; float: right; padding-left:10; padding-top: 8;"><img src="<?php echo base_url()?>images/wrong.jpg" style="width: 20px" title="This email address already exist. Please try again new."></div>
                <div class="patient_does_not_exist_image" style="display: none; float: right; padding-left: 10; padding-top: 4"><img src="<?php echo base_url()?>images/right.jpg" style="width: 20px" title="fadsf"></div>

                <br/>
                
Password: <span class="add_pswd"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="password"
                       name ="password"
                       id ="password"
                       class="add_pswd"
                       required ="require"
                       value =""
                       /></span>
                <br/>
</fieldset> </br> </br>
<fieldset>
<legend> Personal Information </legend>

First Name: <span class="add_fname"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="first_name"
                       id ="first_name"
                       class="add_fname"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['first_name']?>"/></span>
                <br/>

Last Name: <span class="add_lname"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="last_name"
                       id ="last_name"
                       class="add_lname"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['last_name']?>"/></span>
                <br/>


Approved by: <span class="add_approve"><?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="approved_by"
                       id ="approved_by"
                       class="add_approve"
                       required ="require"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['address']?>"/></span> </br>
                

</fieldset>

<input type='submit' id="sign_up_button" name='submit' class='admn_btn' value ='Register'/>

</div>
</div>
<script>
    $('#email_add_log_in').change(function(){
        var form_data = {
           email_add : $(this).val(),
           is_from_ajax : 1
        }
        $.ajax({
                    url:"<?php echo base_url();?>admin/sign_up_validate",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#loader').html(msg);
                    //alert(url);
                        if(msg == false){
                            //$('#log_in_button').hide('fast');
                            
                            document.getElementById('log_in_button').disabled = true;
                            $('.patient_does_not_exist_image').hide('fast');
                            $('.patient_exist_image').show('fast');
                            
                        }
                        else if(msg == true){
                            document.getElementById('log_in_button').disabled = false;
                            $('.patient_exist_image').hide('fast');
                            $('.patient_does_not_exist_image').show('fast');
                        }
                    //alert(msg);
                    //alert("\nalalallaj!");
                    }
                })
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
        else
        {
            var form_data = {
               email_add : $(this).val(),
               is_from_ajax : 1
            }
            $.ajax({
                        url:"<?php echo base_url();?>admin/sign_up_validate",
                        type: 'POST',
                        data: form_data,
                        success: function(msg){
                            if(msg == true){
                                $('.patient_does_not_exist_image').hide('fast');
                                $('.patient_exist_image').show('fast');
                                $('#email_add_hidden').val('not');
                                document.getElementById('sign_up_button').disabled = true;
                                //$(this).val('');
                                //alert($('#email_add_hidden').val());
                                //document.getElementById('password').disabled = false;
                            }
                            else if(msg == false){
                                $('.patient_exist_image').hide('fast');
                                $('.patient_does_not_exist_image').show('fast');
                                $('#email_add_hidden').val('ok');
                                document.getElementById('sign_up_button').disabled = false;
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
    $('.admin_edit').click(function(){
        var form_data = {
            id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/admin_edit",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#div_admin_edit').html(msg);
            }
        })
    })
</script>
<script>
    $('.admin_deactivate').click(function(){
        var form_data = {
            id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/admin_deactivate",
            type : "POST",
            data : form_data,
            success : function(msg){
                noty({type:"notification",text:msg});
                window.setTimeOut(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
    })
</script>

<script>
    $('.admin_activate').click(function(){
        var form_data = {
            id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/admin_activate",
            type : "POST",
            data : form_data,
            success : function(msg){
                //alert(msg);
                noty({type:"notification",text:msg});
                window.setTimeOut(function(){
                        window.location = window.location;
                    }, 2000);
                //document.location = window.location
            }
        })
    })
</script>

<script>
    $('#sign_up_button').click(function(){
        var form_data = {
            email_add : $('#email_add').val(),
            password : $('#password').val(),
            first_name : $('#first_name').val(),
            last_name : $('#last_name').val(),
            approved_by : $('#approved_by').val()
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/sign_up_validate",
            type : "POST",
            data : form_data,
            success : function(msg){
                //alert(msg);
                noty({type:"notification",text:msg});
                window.setTimeOut(function(){
                        window.location = window.location;
                    }, 2000);
                //document.location = window.location
            }
        })
    })
</script>


<?php
    }
  
?>
