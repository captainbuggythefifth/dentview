<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>


<script>
    $(document).ready(function(){
        document.getElementById("service_link").style.backgroundColor="#FFF";
        document.getElementById("service_link").style.padding="7px 15px 7px 73px";
    })
</script>
<div style="border:1px solid #ccc; background:#EFEFEF; height:40px; border-bottom:none; width: auto;"><h4 style=" margin: 10px 15px; float:left;">Services&nbsp;&nbsp;|   </h4>
<a href="#service_add" id="fancybox_add_service" class="add_patient " style="margin:5px 0;">Add Service</a></div><?php if(isset($active) && count($active) > 0 && is_array($active))
        {
    ?>
        <fieldset> <legend> ACTIVE </legend>
<?php
        foreach($active as $service)
        {
            $str = str_ireplace(" ", "-", $service['name']);
            ?>
            <div id="tb_bg">
                
            <div id="name_service">
                <a class="fancybox-manual-<?php echo $str?>">
                    <?php echo $service['name']?>
                </a>
            </div>
            <div class="admin_srv_edit">
            <a href="#edit_service" class="fancybox_edit_service" name="<?php echo $service['id']?>"> Edit
            </a> </div>
            <div class="admin_srv_deactive"><a class="service_deactivate" name="<?php echo $service['id']?>" style="cursor: pointer">Deactivate</a>
                </div><br/>
            
                </div></br>
            <?php
        }
        ?>
            </fieldset>
            <?php
        }
    
    ?>


<?php if(isset($inactive) && count($inactive) > 0 && is_array($inactive))
        {
    ?>
        <fieldset> <legend> INACTIVE </legend>
<?php
        foreach($inactive as $service)
        {
            $str = str_ireplace(" ", "-", $service['name']);
            ?>
            <div id="tb_bg2">
            <div id="name_service">
                <a class="fancybox-manual-<?php echo $str?>">
                    <?php echo $service['name']?>
                </a>
            </div>
            <div class="admin_srv_edit">
            <a href="#edit_service" class="fancybox_edit_service" name="<?php echo $service['id']?>"> Edit
            </a></div>
            <div class="admin_srv_deactive">
                <a style="cursor: pointer" class="service_activate" name="<?php echo $service['id'] ?>">Activate</a>
            </div></br>
            </div><br/>
            <?php
        }
        ?>
            </fieldset>
            <?php
        }
    
    ?>

<div id="edit_service" style="display: none; height: 250; width: 300">
        
</div>





<div id="service_add" style="display: none; height: 230; width: 300">
<div style="border:1px solid #ccc; background:#F4F4F4; padding:10px; height:200px;"></br>
<h3>Add Service</h3>

    Name : <span style="margin-left:50px; padding-left:2px;"><input type="text" id="service_add_name" value=""></span> </br>
    Description : <span style="margin-left:17px; padding-left:2px;"><input type="text" id="service_add_description" value=""></span></br></br>
    <input class="pres_final_btn" type="button" id="service_add_button" value="Save">
</div>
</div>
<script>
    $('.fancybox_edit_service').click(function(){
        var form_data = {
            service_id : this.name
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/service_edit",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#edit_service').html(msg);
            }
        })
    })
</script>

<script>
    $('#service_add_button').click(function(){
        var form_data = {
            name : $('#service_add_name').val(),
            description : $('#service_add_description').val()
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/service_add",
            type : "POST",
            data : form_data,
            success : function(msg){
                //$('#edit_service').html(msg);
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
    })
</script>

<script>
    $('.service_deactivate').click(function(){
        var form_data = {
            service_id : this.name
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/service_deactivate",
            type : "POST",
            data : form_data,
            success : function(msg){
                //$('#edit_service').html(msg);
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        }) 
    })
</script>

<script>
    $('.service_activate').click(function(){
        var form_data = {
            service_id : this.name
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/service_activate",
            type : "POST",
            data : form_data,
            success : function(msg){
                //$('#edit_service').html(msg);
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        }) 
    })
</script>
