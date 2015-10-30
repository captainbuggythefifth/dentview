<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>

<script>
    $(function() {
    $("#tab_trans").tabs();
    $("#date").datepicker({})
    })
</script>


<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if(isset($patient_transaction_info) && count($patient_transaction_info) > 0)
    {
     ?>
        <div id="tab_trans" style="height:493">
            <ul>
                <?php 
                    foreach($patient_transaction_info as $transaction)
                    {
                ?>
		<li><a href="#<?php echo $transaction['id']?>"> <?php echo $transaction['date']?> </a></li>
                
                <?php }
                
                ?>
            </ul>
            <?php foreach($patient_transaction_info as $transaction)
                {
                ?>
                    <div id="<?php echo $transaction['id']?>">
                        Treatment Rendered : <?php echo $transaction['treatment_rendered']?> </br>
                        Fee : <?php echo $transaction['fee']?> </br>
                        Paid : <?php echo $transaction['paid']?> </br>
                        Balance : <?php echo $transaction['balance']?> </br>
                    </div>
            <?php
                }
            ?>
        </div>
<?php
    }
?>

<a href="#" id="transaction_add">Add another transaction for <?php echo $patient_info['first_name'].$patient_info['last_name']?></a>

<div style="display: none" id="display_add_transaction">
    <input type="hidden" id="patient_id" value="<?php echo $patient_info['id']?>"> </br>
                    Date : <input type="text" id="date"> </br>
                    Treatment Rendered : <input type="text" id="treatment_rendered"> </br>
                    Fee : <input type="text" id="fee"> </br>
                    Paid : <input type="text" id="paid"> </br>
                    Balance : <input type="text" id="balance"> </br>
                    <input type="button" value="Save" id="button_save_transaction">
                    
                    <script>
                        $('#button_save_transaction').click(function(){
                            var form_data = {
                                patient_id : $('#patient_id').val(),
                                date : $('#date').val(),
                                treatment_rendered : $('#treatment_rendered').val(),
                                fee : $('#fee').val(),
                                paid : $('#paid').val(),
                                balance : $('#balance').val()
                            }
                            
                            $.ajax({
                                url : "<?php echo base_url()?>admin/transaction_add",
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
</div>



<script>
    $('#transaction_add').click(function(){
        $('#display_add_transaction').show('slow');
    })
</script>