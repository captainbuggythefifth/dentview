<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php if(isset($error))echo "<div id='error' style='background-color:red'><center>".$error."</center></div>";?>

<?php
    $service_id = $this->uri->segment(4);
    foreach($services_with_photos as $service)
    {
        if($service_id == $service['id'])
        {
            ?>
            <center><h2 style="color: #069"><?php echo $service['name']?></h2></center>
            <?php
        }
    }
?>

<div id="admin_main">
    <div style="margin-left: 300px;">
<ul class="sf-menu" id="example" style="margin-top: 15px">
			<li class="">
				<a href="#"><div style="padding: 5px; margin-left: 12px">A-E</div></a>
				<ul>
                                        <?php foreach($services_with_photos as $service)
                                        {
//                                            
//                                       
                                                if($service['name'][0] == 'A' || $service['name'][0] == 'B' || $service['name'][0] == 'C' || $service['name'][0] == 'D' || $service['name'][0] == 'E')
                                                {
                                                ?>
                                                
                                                    <li class='' id="service_<?php echo $service['id'];?>"> 
             
        
                                <a id="link_<?php echo $service['id']; ?>" href="<?php echo base_url()?>admin/upload/service/<?php echo $service['id']?>">
                            <?php echo $service['name']?></a>
                    </li>     
                   
                       
                                                <?php
                                            } 
                                            
                                            }
                                        ?>
					</ul> </li>
                                        
                                        
                                <li class="current">
                                <a href="#"><div style="padding: 5px; margin-left: 12px">F-L</div></a>
				<ul>
                                        <?php foreach($services_with_photos as $service)
                                        {
//                                            
//                                       
                                                if($service['name'][0] == 'F' || $service['name'][0] == 'G' || $service['name'][0] == 'H' || $service['name'][0] == 'I' || $service['name'][0] == 'L')
                                                {
                                                ?>
                                                
                                                    <li class='' id="service_<?php echo $service['id'];?>"> 
             
        
                                <a id="link_<?php echo $service['id']; ?>" href="<?php echo base_url()?>admin/upload/service/<?php echo $service['id']?>">
                            <?php echo $service['name']?></a>
                    </li>                       
                       
                                                <?php
                                            } 
                                            
                                            }
                                        ?>
					</ul>
                        </li>
                        
                        <li class="current">
                                <a href="#"><div style="padding: 5px; margin-left: 12px">M-Q</div></a>
				<ul>
                                        <?php foreach($services_with_photos as $service)
                                        {
//                                            
//                                       
                                                if($service['name'][0] == 'M' || $service['name'][0] == 'N' || $service['name'][0] == 'O' || $service['name'][0] == 'P' || $service['name'][0] == 'Q')
                                                {
                                                ?>
                                                
                                                    <li class='' id="service_<?php echo $service['id'];?>"> 
             
        
                                <a id="link_<?php echo $service['id']; ?>" href="<?php echo base_url()?>admin/upload/service/<?php echo $service['id']?>">
                            <?php echo $service['name']?></a>
                    </li>                       
                       
                                                <?php
                                            } 
                                            
                                            }
                                        ?>
					</ul>
                        </li>
                        
                        <li class="current">
                                <a href="#"><div style="padding: 5px; margin-left: 12px">R-U</div></a>
				<ul>
                                        <?php foreach($services_with_photos as $service)
                                        {
//                                            
//                                       
                                                if($service['name'][0] == 'R' || $service['name'][0] == 'S' || $service['name'][0] == 'O' || $service['name'][0] == 'T' || $service['name'][0] == 'U')
                                                {
                                                ?>
                                                
                                                    <li class='' id="service_<?php echo $service['id'];?>"> 
             
        
                                <a id="link_<?php echo $service['id']; ?>" href="<?php echo base_url()?>admin/upload/service/<?php echo $service['id']?>">
                            <?php echo $service['name']?></a>
                    </li>                       
                       
                                                <?php
                                            } 
                                            
                                            }
                                        ?>
					</ul>
                        </li>
                        
                        <li class="current">
                                <a href="#"><div style="padding: 5px; margin-left: 12px">V-Z</div></a>
				<ul>
                                        <?php foreach($services_with_photos as $service)
                                        {
//                                            
//                                       
                                                if($service['name'][0] == 'V' || $service['name'][0] == 'S' || $service['name'][0] == 'W' || $service['name'][0] == 'X' || $service['name'][0] == 'Y' || $service['name'][0] == 'Z')
                                                {
                                                ?>
                                                
                                                    <li class='' id="service_<?php echo $service['id'];?>"> 
             
        
                                <a id="link_<?php echo $service['id']; ?>" href="<?php echo base_url()?>admin/upload/service/<?php echo $service['id']?>">
                            <?php echo $service['name']?></a>
                    </li>                       
                       
                                                <?php
                                            } 
                                            
                                            }
                                        ?>
					</ul>
                        </li>
			
</ul>
</div>

    <div id="admin_upload_form">
        
<?php echo form_open_multipart('admin/do_upload');
    
    
    $uri_string = $this->uri->segment(4);
   // echo $uri_string;
    $service_id = $uri_string;
    if(!is_numeric($service_id) || $service_id == null)
        echo "";
    
    
        
    if(isset($services_with_photos))
        {
         foreach($services_with_photos as $service) 
         {
             
        ?>
     <ul>
         
         
         <?php
         if($service_id != $service['id'])
             echo "";
         else
         {}
             ?> 
    <?php
    }?>
 
   <!--         <select name="service_id" class="service_slct">
		<?php foreach($data as $service){ ?>
		<option value="<?php echo $service['id']?>"><?php echo $service['name']?></option>
		<?php }} ?>
            </select>
            
        -->
        </ul>
</div>
<div id="admin_upload_pic">
<input type="hidden" value="<?php echo $service_id; ?>" name="service_id"/>
<div class="admin_add_pic">
<input type="file" id="picture" name="userfile" size="20" style="margin: 0 20px 10px 0;"/></br>
<input type="hidden" id="is_preview" name="is_preview" value="0">

<div id="form_loader" style="display: none">
    Name: <input type="text" value="" name="name" style=" margin-left: 57px;"/>
    <br />
    Description: <input type="text" value="" name="description" style=" margin-left: 24px;">
    <br />
    <input type="submit" value="upload"  style=" margin-left: 220px; padding: 2px 15px 2px 15px;"/>
</div>
</div>
</form>

<div class="viewcart">
    <div id="admin_pic_list">
        <ul>
    <?php 
        //echo "alala!";
        
        if(isset($services_with_photos))
        {
            if(is_array($services_with_photos) && count($services_with_photos) > 0)
            {
                 foreach($services_with_photos as $service) 
                 {
                     if($service['id'] == $service_id)
                     {
                         if(is_array($service['photo']) && count($service['photo']))
                         {
                             foreach($service['photo'] as $photo)
                             {
                                if($photo == false)
                                {
                                    echo "There are no photos. Please do upload ASAP";
                                }
                                else
                                {

                                        $str = str_ireplace(" ", "-", $service['name']);
                                    ?>
                                    <li><a class="fancybox-manual-<?php echo $str?>">

                                            <img class="fancybox-manual-<?php echo $str?>" src="<?php echo base_url().$photo['source']?>" width="180" height="180"></img>
                                    </a>
                                    <input type="hidden" id="input_selected_photo">
                                    <div class="edit_info"><a href="#photo_edit" id="<?php echo $photo['id']?>" class="fancybox">Edit Info</a>
                                    </div>
                                    <div class="status">
                                    <?php
                                    if($photo['status'] == "ACTIVE")
                                    {
                                        ?>
                                    <a style="cursor: pointer" style="color:red" class="photo_edit_status" name="<?php echo $photo['id']?>">Deactivate</a>
                                        <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <a style="cursor: pointer" class="photo_edit_status" name="<?php echo $photo['id']?>">Activate</a>
                                     <?php

                                        }
                                     ?>
                                    </div>
                                    </li>
                                    <p id="success"></p>
                                    <?php

                                }
                            }
                         }
                         else
                         {
                             echo "There are no pictures available on this service. Please do add ASAP";
                         }
                     }
                }
            }
            else
            {
                echo "There are no pictures available on this service. Please do add ASAP";
            }
        }
    ?></ul>
        </div>
    </div>
</div>
    </div>
<div id="photo_edit" style="display:none;width: 600;height: 550"></div>

</body>
</html>

<script type="text/javascript">
         $('#picture').click(function(){ 
             $('#form_loader').show('slow');
         });
</script>

<script type="text/javascript">
    $('#preview').click(function(){
        //$('#submit').submit();
        //alert("aalalal");
       // var pic = $('#picture').val();
       // alert(pic['name']);
    
        //var pic = $('input:file:userfile').val(); 
        //var pic = $('input:file:#picture').val();
        //alert(pic);
        //$('#preview').append('<img src='+pic+'/>'+'naa na unta!');
        var form_data = {
            name : $('#name').val(),
            description : $('#description').val(),
            is_preview : '1',
            upload_data : $('input:file:#picture').data()
            
        };
        
        $.makeArray(form_data['upload_data']);
        alert($.isArray(form_data['upload_data']));
        /*$.ajax({
                    url:"<?php echo base_url();?>admin/do_upload",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#preview').html(msg);
                    //alert(msg);
                    //alert(form_data['upload_data'])
                    $('#preview').append("<img src='+form_data['upload_data']+'/>");
                    }
                })
                
                */
        
    });
    
   

</script>
<script>
    $('.fancybox').click(function(){
        
        $('#input_selected_photo').val(this.id);
        var form_data = {
            photo_id : this.id
        }
        
        $.ajax({
            url : "<?php echo base_url();?>admin/photo_edit",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#photo_edit').html(msg)
            }
        })
    })
</script>

<script>
                    $('.photo_edit_status').click(function(){
                        var form_data = {
                            photo_id : this.name
                        }
                        
                        $.ajax({
                            url : "<?php echo base_url()?>admin/photo_edit_status",
                            type : "POST",
                            data : form_data,
                            success : function(msg){
                                noty({type:"notification",text:msg})
                                window.setTimeout(function(){
                                    window.location = window.location;
                                }, 2000);
                                //alert(msg);
                            }
                        })
                    })
</script>

<script>
    $(document).ready(function(){
        document.getElementById("upload_link").style.backgroundColor="#FFF";
        document.getElementById("upload_link").style.padding="7px 15px 7px 73px";
    });
    
    
</script>

<script>
    $(document).ready(function(){
        //document.getElementByName("<?php echo $this->uri->segment(4);?>").style.backgroundColor="#CFF";
        //document.getElementById("upload_link").style.padding="7px 15px 7px 73px";
        
        //$('<?php echo $this->uri->segment(4); ?>').css('background-color','#CFF');
        document.getElementById("service_<?php echo $this->uri->segment(4); ?>").style.backgroundColor="#CFF";
        document.getElementById("link_<?php echo $this->uri->segment(4); ?>").style.color="#3CC";
    });
</script>
