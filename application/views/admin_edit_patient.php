<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');

    if(isset($patient))
    {?>

                        <input type='hidden' name='id' value='<?php echo $patient['id']?>' id='patient_id'>
                        First Name:<input type='text' name='first_name' id='patient_first_name' class='patient_info' value='<?php echo $patient['first_name']?>'></br>
                        Middle Initial:<input type='text' name='mi' id='patient_mi' class='patient_info' value='<?php echo $patient['mi']?>'></br>
                        Last Name:<input type='text' name='last_name' id='patient_last_name' class='patient_info' value='<?php echo $patient['last_name']?>'></br>
                        Last Logged in:<input type='text' name='last_logged_in' id='patient_last_logged_in' class='patient_info' value='<?php echo $patient['last_logged_in']?>'></br>
                        Address:<input type='text' name='address' class='patient_info' id='patient_address' value='<?php echo $patient['address']?>'></br>
                        Email Address:<input type='text' name='email_add' id='patient_email_add' value='<?php echo $patient['email_add']?>'>
                        <input type='hidden' value='<?php echo $patient['password']?>' name='password' id='patient_password'>
                            <input type='button' value='Edit' class='logbtn' id='edit_patient'>
                        <div id='display_message' style='display:none'>
                        </div>

                        <script>
                            $('#edit_patient').click(function(){
                                var form_data = {
                                    id : $('#patient_id').val(),
                                    first_name : $('#patient_first_name').val(),
                                    mi : $('#patient_mi').val(),
                                    last_name : $('#patient_last_name').val(),
                                    last_logged_in : $('#patient_last_logged_in').val(),
                                    address : $('#patient_address').val(),
                                    email_add : $('#patient_email_add').val(),
                                    password : $('#patient_password').val()
                                }
                                $.ajax({
                                    url:'<?php echo base_url()?>administer-patient-edit',
                                    type:'POST',
                                    data:form_data,
                                    success:function(msg){
                                        alert(msg);
                                        window.location = document.location;
                                    }
                                })
                            })
                        </script>
                        <script>
                            $('#patient_email_add').change(function(){
                                var x=$(this).val();
                                var atpos=x.indexOf('@');
                                var dotpos=x.lastIndexOf('.');
                                if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
                                {
                                  //$('#image_for_email').hmtl('OK');
                                  document.getElementById('edit_patient').disabled = true;
                                  alert('This '+ x +' email address is not valid. The edit button is disabled. It will only enable if you write a valid email address.');
                                  $('#patient_email_add').val(''+x);
                                }
                                else
                                {
                                    document.getElementById('edit_patient').disabled = false;
                                }
                            })
                        </script>

        <?php                
    }
?>

