<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>

<div id="patient_for_edit" style="display: none; width: 300; height: 300">
    
 </div>
<div id="patient_record" style="display: none; width: 600; height: 600">
    
</div>

<div id="patient_transaction" style="display: none; width: 600; height: 600">
    
</div>
<div id="patient_tooth" style="display: none; width: 600; height: 600">
    
</div>

<script>
    $(document).ready(function(){
        document.getElementById("patient_link").style.backgroundColor="#FFF";
        document.getElementById("patient_link").style.padding="7px 15px 7px 73px";
    })
</script>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($complete_info_from_active_patient))
{
    ?>
    <div style="border:1px solid #ccc; background:#EFEFEF; height:40px; border-bottom:none; width: auto;"><h4 style=" margin: 10px 15px; float:left;">All active patients&nbsp;&nbsp;|   </h4>
        <a href="#sign_up" id="admin_add_patient" class="add_patient" style="margin:5px 0;">Add Patient</a>
        <div style="float:left">Search for Patient <input type="text" id="search_patient"></div>
        
    </div>
    <div class="admin_box">
        
<?php
    
    foreach($complete_info_from_active_patient as $patient)
    {
        
?>
    
        <ul style="padding-left :-px">
            
            <center><img style=" width: 100px; height: 100px; border: 1px solid #ccc; margin-top:8px;" src="<?php echo base_url().$patient['photo_info']['source']?>"/></center>
                <div class="admin_name">Name : <?php echo $patient['patient_info']['first_name']." ".$patient['patient_info']['last_name']?></div>
                <li><a class="fancybox" href="#patient_for_edit" id="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/info.png" title="View All Info"></a></li>
                <li><a href="#patient_record" class="fancybox_view_patient_record" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/history.png" title="View Patient History"></a></li>
                <li><a href="#patient_record" class="fancybox_view_patient_tooth_record" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/tooth.png" title="View Patient Tooth History"></a></li>
                <li><a href="#patient_transaction" class="fancybox_view_patient_transaction" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/transactions.png" title="View Patient Transaction History"></a></li>
                <li><a class="edit_patient_deactivate" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/x.png" title="Deactivate"></a></li>
                
        </ul> 
    

    
    <?php
    }
    ?>
    
    <?php
    }
    ?>

</div>


    
    
<?php
    if(isset($complete_info_from_inactive_patient))
    {
        ?>
        <div style="border:1px solid #ccc; background:#EFEFEF; height:40px; border-bottom:none;  width: 1044px;"><h4 style=" margin: 10px 15px;">Deactivated patients</h4>    <div class="admin_box2">
<?php
        foreach ($complete_info_from_inactive_patient as $patient)
        {
    ?>        
        
        
    
        <ul>
            
            <center><img style="width: 100px; height: 100px; border: 1px solid #ccc; margin-top:8px;" src="<?php echo base_url().$patient['photo_info']['source']?>"></center>
                <div class="admin_name">Name : <?php echo $patient['patient_info']['first_name']." ".$patient['patient_info']['last_name']?></div>
                <li><a class="fancybox_activate" href="#patient_for_edit" id="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/info.png" title="View All Info"></a></li>
                <li><a class="edit_patient_activate" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/add_icon.png" title="Activate"></a></li>
        </ul>
        


   
                       
    <?php

        }
    }
?>
        </div>
        </div>
        
        <div id="success"> </div>

<script>
    $('.fancybox').live('click',function(){
        var form_data = {
            patient_id : this.id
        }
        $.ajax({
            url:'<?php echo base_url()?>admin/patient_for_edit',
            type:'POST',
            data:form_data,
            success:function(msg){
                $('#patient_for_edit').html(msg);
            }
        })
    })
</script>

<script>
    //patient_for_edit_and_activate
    $('.fancybox_activate').live('click',function(){
        var form_data = {
            patient_id : this.id
        }
        $.ajax({
            url:'<?php echo base_url()?>admin/patient_for_edit_and_activate',
            type:'POST',
            data:form_data,
            success:function(msg){
                $('#patient_for_edit').html(msg)
            }
        })
    })
</script>

<script>
    $('.fancybox_view_patient_record').live('click',function(){
        var form_data = {
            patient_id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/record_view_patient",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#patient_record').html(msg);
            }
        })
    })
</script>

<script>
    $('.fancybox_view_patient_tooth_record').live('click',function(){
        
        var form_data = {
            patient_id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/tooth_view",
            type : "POST",
            data : form_data,
            success : function(msg){
                
                $('#patient_record').html(msg);
            }
        })
    })
</script>


<script>
    $('.fancybox_view_patient_transaction').live('click',function(){
        var form_data = {
            patient_id : this.name
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/transaction_view",
            type : "POST",
            data : form_data,
            success : function(msg){
                $('#patient_transaction').html(msg);
            }
        })
    })
</script>


 <script>
     $('#printer').click(function(){
        window.print();
     });
 </script>
 
 <script>
    $(".edit_patient_deactivate").live('click',function(){
    //alert('akakakaakakjaksf');
    var form_data = {
        patient_id : this.name

    }

    $.ajax({
        url:"<?php echo base_url()?>admin/patient_deactivate",
        type:"POST",
        data:form_data,
        success:function(msg){
            noty({type:"notification",text:msg});
            window.setTimeOut(function(){
            window.location = window.location
            },2000);
        }
    })
    })
</script>
 
<script>
    $(".edit_patient_activate").live('click',function(){
    //alert('akakakaakakjaksf');
    var form_data = {
        patient_id : this.name

    }

    $.ajax({
        url:"<?php echo base_url()?>admin/patient_activate",
        type:"POST",
        data:form_data,
        success:function(msg){
            noty({type:"notification",text:msg});
            window.setTimeOut(function(){
            window.location = window.location
            },2000);
        }
    })
    })
</script>

<script>
    $('#search_patient').keyup(function(){
       
            var form_data = {
                last_name : $(this).val()
            }
        $.ajax({
        url:"<?php echo base_url()?>admin/patient_search",
        type:"POST",
        data:form_data,
        success:function(msg){
            $(".admin_box").html(msg);
        }
    })
    })
</script>

<script>
    $('#search_patient').blur(function(){
       
            var form_data = {
                last_name : "all"
            }
        $.ajax({
        url:"<?php echo base_url()?>admin/patient_search",
        type:"POST",
        data:form_data,
        success:function(msg){
            $(".admin_box").html(msg);
        }
    })
    })
</script>
 
 


   

