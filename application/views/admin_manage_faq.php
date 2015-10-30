<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    $(function() {
    $("#date").datepicker({});
  });
</script>
<div style="border:1px solid #ccc; background:#EFEFEF; height:40px;  width: auto;"><h4 style=" margin: 10px 15px; float:left;">F.Q.A &nbsp;&nbsp;|   </h4> 
<a style="cursor: pointer; margin:5px 0;" id="fancybox_add_faq" href="#div_add_faq" class="add_patient">Add FAQ</a>
<div id="div_add_faq" style="display: none">
<div class="bg_table">
    Date : <input type="text" id="date" value=""></br>
    Question : <br /><textarea id="question" cols="30" rows="5"></textarea><br/>
    Answer : <br /><textarea id="answer" cols="30" rows="5"></textarea><br/>
    <input type="button" id="button_add_faq" value="ADD" class="add_patient">
</div>
</div>
<?php if(isset($faq_active_info))
        {
            if(is_array($faq_active_info) && count($faq_active_info) > 0)
            {
                $i = 0;
                ?>
                <fieldset><legend>Active FAQ</legend>
                <?php
                foreach($faq_active_info as $faq_info)
                {
                    ?>
                    <div id="admin_resrv" style=" border:1px solid #0F0; background-color: <?php if($i%2 == 0) {echo '#CFC';} else {echo '#CFF';}?> " >
                    <div class="admin_res_d">Date : <?php echo date_format(date_create($faq_info['date']),"F d, Y")?></div>
                    
                    <div class="admin_res_dctr">Question : <?php 
                                                            $str = $faq_info['question'];
                                                        if(strlen($str) > 30)
                                                        {
                                                            $new = "";
                                                            for($i=0;$i<30;$i++)
                                                            {
                                                                $new = $new.$str[$i];
                                                            }
                                                            
                                                            echo $new."...";
                                                        }
                                                        else
                                                        {
                                                            echo $str;
                                                        }
                                                        
                                                        ?>
                                                            
                    </div>
                    <div class="admin_res_p">Answer : <?php 
                                                        $str = $faq_info['answer'];
                                                        if(strlen($str) > 30)
                                                        {
                                                            $new = "";
                                                            for($i=0;$i<30;$i++)
                                                            {
                                                                $new = $new.$str[$i];
                                                            }
                                                            
                                                            echo $new."...";
                                                        }
                                                        else
                                                        {
                                                            echo $str;
                                                        }
                                                        
                                                        ?>
                    </div>&nbsp;
                    <a class="admin_faq_edit resched_btn" href="#div_faq_edit" name="<?php echo $faq_info['id']?>">Edit</a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="admin_faq_deactivate resched_btn" style="cursor:pointer" name="<?php echo $faq_info['id']?>">Deactivate</a>
                    </div>
                
                    <?php
                    $i++;
                }
                ?>
                    </fieldset>
                    <?php
            }
        }
    ?>

<?php if(isset($faq_inactive_info))
        {
            if(is_array($faq_inactive_info) && count($faq_inactive_info) > 0)
            {
                $i = 0;
                ?>
                <fieldset><legend>Inactive FAQ</legend>
                <?php
                foreach($faq_inactive_info as $faq_info)
                {
                    ?>
                    <div id="admin_resrv" style="border:1px solid #F90; background-color: <?php if($i%2 == 0) echo '#FF9'; else echo '#FF9';?>" >
                    <div class="admin_res_d">Date : <?php echo date_format(date_create($faq_info['date']),"F d, Y")?></div>
                    
                    <div class="admin_res_dctr">Question : <?php $str = $faq_info['question'];
                                                        if(strlen($str) > 30)
                                                        {
                                                            $new = "";
                                                            for($i=0;$i<30;$i++)
                                                            {
                                                                $new = $new.$str[$i];
                                                            }
                                                            
                                                            echo $new."...";
                                                        }
                                                        else
                                                        {
                                                            echo $str;
                                                        }
                                                        
                                                        ?>
                    </div>
                    <div class="admin_res_p">Answer : <?php
                                                        $str = $faq_info['answer'];
                                                        if(strlen($str) > 20)
                                                        {
                                                            $new = "";
                                                            for($i=0;$i<20;$i++)
                                                            {
                                                                $new = $new + $str[$i];
                                                            }
                                                            
                                                            echo $new;
                                                        }
                                                        else
                                                        {
                                                            echo $str;
                                                        }
                                                        ?>
                    </div>&nbsp;
                    <a class="admin_faq_edit resched_btn" href="#div_faq_edit" name="<?php echo $faq_info['id']?>">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="admin_faq_activate resched_btn" style="cursor:pointer" name="<?php echo $faq_info['id']?>" >Activate</a>
                    </div>
                
                    <?php
                    $i++;
                }
                ?>
                    </fieldset>
                    <?php
            }
        }
    ?>

                    
<div id="div_faq_edit" style="display:none; height: 300; width: 300"></div>

<script>
    $('#button_add_faq').click(function(){
        var form_data = {
            date : $('#date').val(),
            question : $('#question').val(),
            answer : $('#answer').val()
        }
        if(form_data['date'] == "")
        {
            alert("Please enter a date");
        }
        if(form_data['question'] == "")
        {
            alert("Please enter a question");
        }
        if(form_data['answer'] == "")
        {
            alert("Please enter an answer");
        }
        else
            {
        $.ajax({
            url : "<?php echo base_url()?>admin/faq_add",
            type : "POST",
            data : form_data,
            success : function(msg){
                noty({type:"notification",text:msg})
                window.setTimeout(function(){window.location = window.location}, 2000);
            }
        })
        }
    })
</script>

<script>
    $('.admin_faq_edit').click(function(){
        
    var form_data = {
            faq_id : this.name
           
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/faq_edit",
            type : "POST",
            data : form_data,
            success : function(msg){
                //noty({type:"notification",text:msg})
                //window.setTimeout(function(){window.location = window.location}, 2000);
                $('#div_faq_edit').html(msg);
            }
        })
        
    })
    
</script>

<script>
    $('.admin_faq_deactivate').click(function(){
        var form_data = {
            faq_id : this.name
           
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/faq_deactivate",
            type : "POST",
            data : form_data,
            success : function(msg){
                noty({type:"notification",text:msg})
                window.setTimeout(function(){window.location = window.location}, 2000);
                //$('#div_faq_edit').html(msg);
            }
        })
    
    })
</script>

<script>
    $('.admin_faq_activate').click(function(){
        var form_data = {
            faq_id : this.name
           
        }
        
        $.ajax({
            url : "<?php echo base_url()?>admin/faq_activate",
            type : "POST",
            data : form_data,
            success : function(msg){
                noty({type:"notification",text:msg})
                window.setTimeout(function(){window.location = window.location}, 2000);
                //$('#div_faq_edit').html(msg);
            }
        })
    
    })
</script>