<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if(isset($customer_care_active_info))
    {
        
        ?>
        <div style="border:1px solid #ccc; background:#EFEFEF; height:40px;"><h4 style=" margin: 10px 15px;">Customer Care</h4></div>
        <div style="border:1px solid #ccc; background:#F7F7F7; border-top:none; height:500px;">
        <fieldset> <legend> <h4 style="color:#069;">ACTIVE</h4>  </legend>
        <?php
        foreach($customer_care_active_info as $customer_care)
        {
            
            ?>
            <div style=" background: #CFC; border:1px solid #0F0; width: 220px; float: left; padding: 5px; margin:5px;">
            <?php
            if(is_array($customer_care['patient_info']) && count($customer_care['patient_info']) > 0)
            {
            ?>
                    Patient : <?php echo $customer_care['patient_info']['first_name']." ".$customer_care['patient_info']['first_name']?> </br>
                    Query : <?php echo $customer_care['query']?> </br>
                    About : <?php echo $customer_care['about']?> </br>
                    Email : <a href="#div_email_patient" class="fancybox" name="<?php echo $customer_care['id']?>"><?php echo $customer_care['patient_info']['email_add']?></a></br>
                    Phone No. : <?php echo $customer_care['patient_info']['mobile_number']?>
                    
            <?php
            }
            else
            {
                ?>
                There are no more active in the list.
                <?php
            }
            ?>
              </div>
                        <?php
        }
        ?>
           </fieldset>
        <?php
    }
    
    
    if(isset($customer_care_inactive_info))
    {
        ?>
        <fieldset> <legend> <h4 style="color:#069;">INACTIVE</h4> </legend>
        <?php
        foreach($customer_care_inactive_info as $customer_care)
        {
            ?>
            <div style="background: #FF9; border:1px solid #F90; width: 220px; float: left; padding: 5px; margin:5px; ">
            <?php
            if(is_array($customer_care['patient_info']) && count($customer_care['patient_info']) > 0)
            {
            ?>
                    Patient : <?php echo $customer_care['patient_info']['first_name']." ".$customer_care['patient_info']['first_name']?> </br>
                    Query : <?php echo $customer_care['query']?> </br>
                    About : <?php echo $customer_care['about']?> </br>
                    Email : <a href="#div_email_patient" class="fancybox" name="<?php echo $customer_care['id']?>"><?php echo $customer_care['patient_info']['email_add']?></a></br>
                    Phone No. : <?php echo $customer_care['patient_info']['mobile_number']?></br>
                    
            <?php
            }
            else
            {
                ?>
                    There are no more active in the list.
                <?php
            }
            ?>
            </div>
                    <?php
        }
        ?>
            </fieldset>
            <?php
    }
?>
</div>
<script>
    $(document).ready(function(){
        document.getElementById("customer_care_link").style.backgroundColor="#FFF";
        document.getElementById("customer_care_link").style.padding="7px 15px 7px 73px";
    })
</script>

<div id="div_email_patient" style="display: none; width: 300; height: 300">
    
</div>
                        
<script>
    $('.fancybox').click(function(){
        var form_data = {
            id : this.name
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/customer_care_send",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#div_email_patient').html(msg);
            }
        })
    })
</script>