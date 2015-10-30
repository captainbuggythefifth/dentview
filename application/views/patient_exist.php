<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($patient_info))
{
    echo form_open('patient-log-in-validate'); 
    
    $patient = array(
            'email_add' => 'email_add',
            'password'  => 'password',
    );
?>
    Your Email Address <?php echo $patient_info['email_add']?> already exist. Are you <a id="form_load" href="#"><?php echo $patient_info['first_name']?></a>? </br>
    If yes, please do fill up the password box below. </br>
    <input type="hidden" value="<?php echo $patient_info['email_add']?>" name="email_add">
    <input type="password" require="required" name="password" onclick="this.value=''"/> <input type="submit" value="Log in">
    There should be no double email address. If you are not <?php echo $patient_info['first_name']?> please do change your email address upon registration.
    <a href="<?php echo base_url();?>patient-sign-up">SIGN UP AGAIN</a>
    
<?php echo form_close();
}
?>

