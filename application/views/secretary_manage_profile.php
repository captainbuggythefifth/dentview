<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');


if(isset($this->session->userdata['secretary_info']['id']))
{
?>
<input type="hidden" id="secretary_id" value="<?php echo $this->session->userdata['secretary_info']['id']?>">
First Name : <input type="text" id="first_name" value="<?php echo $this->session->userdata['secretary_info']['first_name']?>"> <br/>
Last Name : <input type="text" id="last_name" value="<?php echo $this->session->userdata['secretary_info']['last_name']?>"> <br/>
Email Address : <input type="text" id="email_add" value="<?php echo $this->session->userdata['secretary_info']['email_add']?>"> <br/>
Password : <input type="text" id="password" value=""> <br/>
Re-type Password : <input type="text" id="re-password" value=""> <br/>

<input type="button" value="Edit" id="edit">
<!-- Under of Doctor : <select type="text" id="under_of">
                        <?php if(isset($doctors))
                        {
                            foreach($doctor as $doctor)
                            {
                                ?>
                                <option value="<?php echo $doctor['id']?>"> <?php echo $doctor['first_name']." ".$doctor['last_name']?> </option>
                                <?php
                            }
                        }
                            ?>
                    </select> -->

<script>
    $('#edit').click(function(){
        var form_data = {
            //id : $('#secretary_id').val(),
            first_name : $('#first_name').val(),
            last_name : $('#last_name').val(),
            email_add : $('#email_add').val(),
            password : $('#password').val(),
            re_password : $('#re-password').val()
        }
        if(form_data['password'] != form_data['re_password'])
        {
            alert("Retyped password did not match the first");
        }
        if(form_data['password'] == "" || form_data['password'] == form_data['re_password'])
        {
            $.ajax({
                url : "<?php echo base_url()?>secretary/secretary_edit",
                type : "POST",
                data : form_data,
                success : function(msg){
                    noty({type:"notification",text:msg});
                    window.setTimeout(function(){window.location = window.location}, 2000);
                }
            })
        }
    })
</script>
<?php } ?>