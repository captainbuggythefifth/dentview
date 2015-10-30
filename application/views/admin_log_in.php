<?php 
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>

<?php echo form_open('admin-log-in-validate'); ?>
<?php 
    $admin_info = array(
            'email_add' => 'email_add',
            'password'  => 'password',
    );
?>
Email Address: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="text"
                       name ="email_add"
                       id ="email_add"
                       value =""/>
                <br/>

Password: <?php //echo form_input($patient_info['first_name']);?> 
                <input type ="password"
                       name ="password"
                       id ="password"
                       value =""/>
                <br/>
                        <input type="submit"
                       name="submit"
                       value ="Log in"/>
<?php echo form_close()?>
<?php echo validation_errors('<p class="errors">')?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
