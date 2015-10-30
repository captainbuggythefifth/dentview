<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>
<script>
    $(document).ready(function(){
        document.getElementById("doctor_link").style.backgroundColor="#FFF";
        document.getElementById("doctor_link").style.padding="7px 15px 7px 73px";
    })
</script>

<div style="border:1px solid #ccc; background:#EFEFEF; height:40px;  width: auto;"><h4 style=" margin: 10px 15px; float:left;">All Doctors&nbsp;&nbsp;|   </h4>
<a style="text-decoration: none; margin:5px 0;" href="#div_add_doctor" class="fancybox add_patient">Add Doctor</a></div>
    

<div id="div_add_doctor" style="display: none; width: 310; height: 300">
<div class="bg_table" style="height:358px; padding:1px; ">
<div class="p_adjust" ></div>
    <fieldset> <legend><h4 style="color: #069;">Log in Information</h4></legend>
        Email Address : <span class="doc_emladd"><input type="text" id="doctor_email_add"></span></br>
        Password : <span class="doc_pswd"><input type="text" id="doctor_password"></span></br>
    </fieldset>
    <fieldset> <legend><h4 style="color: #069;">Personal Information</h4></legend>
        First Name : <span class="doc_fname"><input type="text" id="doctor_first_name"></span></br>
        MI : <span class="doc_mi"><input type="text" id="doctor_mi" /></span></br>
        Last Name : <span class="doc_lname"><input type="text" id="doctor_last_name"></span></br>
        Address : <span class="doc_address"><input type="text" id="doctor_address"></span></br>
        License Number : <span class="doc_license"><input type="text" id="doctor_license"></span></br>
    </fieldset>
    <input type="button" id="button_add_doctor" value="Add" class="h_btn_add" >
</div>
</div>
<div class="admin_box3">
<?php
    if(isset($complete_info_from_doctor))
    {
        //print_r($complete_info_from_doctor);
        foreach($complete_info_from_doctor as $doctor)
        {
          
    ?>
    <ul>
            
        <center><img style="width: 100px; height: 100px; border: 1px solid #ccc; margin-top:8px;" src="<?php echo base_url().$doctor['photo_info']['source']?>"></center>
                <div class="admin_name">Name : <?php echo $doctor['doctor_info']['first_name']." ".$doctor['doctor_info']['last_name']?></div>
        		<li><img src="<?php echo base_url()?>/images/icon/info.png" title="View All Info"><a class="fancybox view_link" href="#doctor_for_edit_<?php echo $doctor['doctor_info']['id']?>" id="<?php echo $doctor['doctor_info']['id']?>">View All Info</a></li>
    
    </ul>
    

        
        <div id="doctor_for_edit_<?php echo $doctor['doctor_info']['id']?>" style="display: none; width: 380; height: 450">
        
            <fieldset>
                <legend><h4 style="color: #F60">Profile Picture</h4></legend>
                <div id="doc_view">
                
                
                	<div class="doc_img"><img src="<?php echo base_url().$doctor['photo_info']['source']?>" style="width:80;height:80">
                    <?php echo form_open_multipart('admin/doctor_do_upload',"id='uploader'");?></div>


                    <div class="doc_up" align="center"><input type="file" name="userfile" size="20" id="upload_file"/>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_info']['id']?>"></div>
                    <br /><br />
                    <div class="doc_sub" align="center"><input type="submit" value="Upload" class="doc_btn"></div>
				</ul>
                </div>
                    </form>
            </fieldset>
            
            <fieldset>
                <legend><h4 style="color: #F60">Personal Information</h4></legend>
                    <input id="doctor_id_<?php echo $doctor['doctor_info']['id']?>" type="hidden" value="<?php echo $doctor['doctor_info']['id']?>">
                    First Name : <span class="doc_view_fname"><input type="text" id="doctor_first_name_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['first_name']?>"></span> </br>
                    Mi : <span class="doc_view_mi"><input type="text" id="doctor_mi_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['mi']?>"></span>  </br>
                    Last Name : <span class="doc_view_lname"><input type="text" id="doctor_last_name_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['last_name']?>"></span> </br>
                    Address : <span class="doc_view_address"><input type="text" id="doctor_address_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['address']?>"></span> </br>
                    Email Address : <span class="doc_view_emladd"><input type="text" id="doctor_email_add_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['email_add']?>"></span> </br>
                    License Number : <span class="doc_view_license"><input type="text" id="doctor_license_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['license']?>"></span> </br>
                    <input type="hidden" id="doctor_password_<?php echo $doctor['doctor_info']['id']?>" value="<?php echo $doctor['doctor_info']['password']?>"> </br>
                    <input type='button' id="edit_doctor_button_<?php echo $doctor['doctor_info']['id']?>" name='submit' class="doc_view_btn" value ='Edit'/>

            </fieldset>
            <?php if(isset($doctor['expertise_info']) && is_array($doctor['expertise_info']))
            {
                ?>
            
            <fieldset>
                <legend><h4 style="color: #F60">Expertise</h4></legend>
                    <?php
                        
                        foreach($doctor['expertise_info'] as $service)
                            {
                                    if($service['status'] == "ACTIVE")
                                    {
                                    
                                
                                    ?>
                                    
                                    <a style="text-decoration: none; cursor: pointer" class="button_delete_doctor_service" name="<?php echo $doctor['doctor_info']['id']?>/<?php echo $service['id']?>">
                                        <img src="<?php echo base_url()?>images/remove_icon.png "style="width:10;height:10;"><?php echo $service['name']?>
                                    </a>
                                    </br>  
                                    <?php
                                    }
                                
                            }
                            
                    ?>
            </fieldset>
            <?php
            }
            ?>
                    <?php
                        if(isset($doctor['not_in_service_info']) && is_array($doctor['not_in_service_info']))
                            {
                            ?>
                                <fieldset>
                                    <legend><h4 style="color: #F60">Available Expertise</h4></legend>
            
            <?php
                                foreach($doctor['not_in_service_info'] as $not_in_service)
                                {
                                    ?>
                                    <a style="text-decoration: none; cursor: pointer" class="button_doctor_add_service" name="<?php echo $doctor['doctor_info']['id']?>/<?php echo $not_in_service['id']?>">
                                        <img src="<?php echo base_url()?>images/add_icon.png" style="width:10;height:10;"><?php echo $not_in_service['name']?> </br> 
                                    </a>
                                    <?php
                                }
                                ?>
                                    </fieldset>
                                    <?php
                            }
                         
                    ?>
            
        </div>
    
        <script>
            $('#edit_doctor_button_<?php echo $doctor['doctor_info']['id']?>').click(function(){
                
                var x=$('#doctor_email_add_<?php echo $doctor['doctor_info']['id']?>').val();
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
                        id:$('#doctor_id_<?php echo $doctor['doctor_info']['id']?>').val(),
                        first_name:$('#doctor_first_name_<?php echo $doctor['doctor_info']['id']?>').val(),
                        mi:$('#doctor_mi_<?php echo $doctor['doctor_info']['id']?>').val(),
                        last_name:$('#doctor_last_name_<?php echo $doctor['doctor_info']['id']?>').val(),
                        address:$('#doctor_address_<?php echo $doctor['doctor_info']['id']?>').val(),
                        email_add:$('#doctor_email_add_<?php echo $doctor['doctor_info']['id']?>').val(),
                        password:$('#doctor_password_<?php echo $doctor['doctor_info']['id']?>').val(),
                        license:$('#doctor_license_<?php echo $doctor['doctor_info']['id']?>').val()
                    }
                    
                    $.ajax({
                                url:"<?php echo base_url();?>admin/doctor_edit",
                                type: 'POST',
                                data: form_data,
                                success: function(msg){
                                    noty({type:"notification",text:msg});
                                    window.setTimeout(function(){
                                    window.location = window.location;
                                }, 2000);
                                }
                    })
                }
            })
        </script>
<?php }
        }
        ?></div>
        
        <script>
            $('.doctor_deactivate_service').click(function(){
                var str = this.id;
                //alert(str);
                return false;
            });
        </script>
        <?php
        
        ?>
<script>
    $('#button_add_doctor').click(function(){
        var form_data = {
            email_add : $('#doctor_email_add').val(),
            password : $('#doctor_password').val(),
            first_name : $('#doctor_first_name').val(),
            mi : $('#doctor_mi').val(),
            last_name : $('#doctor_last_name').val(),
            address : $('#doctor_address').val()
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/add_doctor",
            type : 'POST',
            data: form_data,
            success: function(msg){
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
            
        });
    })
</script>

<script>
    $('.button_doctor_add_service').click(function(){
        var form_data = {
            doctor_service : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/doctor_add_service/"+form_data['doctor_service'],
            type : 'GET',
            data: form_data,
            success: function(msg){
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
            
        });
    })
</script>


<script>
    $('.button_delete_doctor_service').click(function(){
        var form_data = {
            doctor_service : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/doctor_deactivate_service/"+form_data['doctor_service'],
            type : 'GET',
            data: form_data,
            success: function(msg){
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
            
        });
    })
</script>
        


