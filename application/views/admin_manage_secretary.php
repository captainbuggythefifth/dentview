<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
//print_r($secretary_active_info);
?>
    <a href="#div_add_secretary" id="fancybox_add_secretary" style="cursor: pointer">Add Secretary</a>
<?php
if(isset($secretary_active_info))
{
    if(is_array($secretary_active_info) && count($secretary_active_info) > 0)
    {
        ?>
        <fieldset><legend>Active Secretaries</legend>
        <?php
        foreach($secretary_active_info as $secretary)
        {
            
            ?>
            Name : <?php echo $secretary['first_name']." ".$secretary['last_name']; ?>
            &nbsp; &nbsp;
            Secretary of : <?php echo $secretary['doctor_info']['first_name']." ".$secretary['doctor_info']['last_name']?>
            <?php
        }
        ?>
        </fieldset>
        <?php
    }
    else
    {
        echo "There are no active secretaries";
    }
}
?>

    <div id="div_add_secretary" style="display: none">
        First Name : <input type="text" id="first_name"> <br/>
        Last Name : <input type="text" id="last_name"> <br/>
        Email Address : <input type="text" id="email_add"> <br/>
        Password : <input type="text" id="password"> <br/>
        Under of Doctor : <select id="under_of"> 
                            <?php if(isset($doctor_info))
                                    {
                                        if(is_array($doctor_info) && count($doctor_info) > 0)
                                        {
                                            foreach($doctor_info as $doctor)
                                            {
                                                ?>
                                                <option value="<?php echo $doctor['id']?>">
                                                    <?php echo $doctor['first_name']." ".$doctor['last_name']?> &nbsp;
                                                    
                                                </option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                        </select>
        <input type="button" id="save_secretary" value="Save">
    </div>

    <script>
        $('#save_secretary').click(function(){
            var form_data = {
                first_name : $('#first_name').val(),
                last_name : $('#last_name').val(),
                email_add : $('#email_add').val(),
                password : $('#password').val(),
                under_of : $('#under_of').val()
            }
            
            $.ajax({
                url : "<?php echo base_url()?>admin/secretary_add",
                type : "POST",
                data : form_data,
                success : function(msg){
                    noty({type:"notification",text:msg});
                    window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
                }
            })
        })
    </script>

