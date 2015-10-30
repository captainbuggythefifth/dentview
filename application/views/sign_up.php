
<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<H3>SIGN-UP</H3>

<?php 
    if(isset($msg))
    {
        echo $msg;
        unset($msg);
    }
?>
<? echo form_open('patient/sign_up_validate'); ?>
<?php 
    $patient_info = array(
            'first_name' => 'first_name',
            'mi' => 'mi',
            'last_name' => 'last_name',
            'email_add' => 'email_add',
            'password'  => 'password',
            'address' => 'address',
            'captcha' => 'captcha'
    );
?>
First Name: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="first_name"
                       id ="first_name"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['first_name']?>"/>
                <br/>
Middle Initial: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="mi"
                       id ="mi"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['mi']?>"/>
                <br/>

Last Name: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="last_name"
                       id ="last_name"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['last_name']?>"/>
                <br/>

Email Address: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="email_add"
                       id ="email_add"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['email_add']?>"/>
                <br/>

Password: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="password"
                       name ="password"
                       id ="password"
                       value =""/>
                <br/>

Address: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="address"
                       id ="address"
                       value ="<?php if(isset($patient_retry_info)) echo $patient_retry_info['address']?>"/>
                
Captcha:        <input type="text" name="captcha" style="" require="required">
                
<span class='label' style="margin-left: 115px; border: 1px solid #FFF; width: 150px;"><img src="<?php base_url()?>images/captcha/imagebuilder.php" border="1"></span>

                <input type="submit"
                       name="submit"
                       value ="Register"/>
<?  echo form_close();?>
<?  echo validation_errors('<p class="errors">')?>

 