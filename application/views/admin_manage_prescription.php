<?php
    if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>
<script>
    $(document).ready(function(){
        document.getElementById("prescription_link").style.backgroundColor="#FFF";
        document.getElementById("prescription_link").style.padding="7px 15px 7px 73px";
    })
</script>
<div style="border:1px solid #ccc; background:#EFEFEF; height:40px;  width: auto;"><h4 style=" margin: 10px 15px; float:left;">Prescription &nbsp;&nbsp;|   </h4> 
	<a href="#make_prescription" id="make_new_prescription" class="add_patient" style="margin:5px 0;">Make a Prescription</a></div>

<div id="div_prescription_edit" style="display:none; width: 500; height: 500; "></div>
<div id="admin_prescription" style="border-top:none;">
<?php 
    if(isset($prescriptions))
    {
        if(is_array($prescriptions) && count($prescriptions) > 0)
        {
            foreach($prescriptions as $prescription)
            {
                ?>
              <ul>  
                <li>Date : <?php echo $prescription['date']?></li>
                <li>Dr. <?php echo $prescription['doctor_info']['first_name']." ".$prescription['doctor_info']['last_name']?></li>
                <li>Patient : <?php echo $prescription['patient_info']['first_name']." ".$prescription['patient_info']['last_name']?> &nbsp;
                <a href="#div_prescription_edit" class="prescription_edit" name="<?php echo $prescription['id']?>">Edit</a></li></br>
               </ul>
                <?php
            }
        }
    }
    

    if(isset($patients) && isset($doctors))
    {
?>
</div>
<div id="make_prescription" style="display : none">
<div style="border:1px solid #ccc; background:#F4F4F4; padding:10px;">    
    Date : <span style="margin-left:25px; padding-left:2px;"><input type="text" id="date" align="right"></span><br/>
    <?php if(is_array($patients) && count($patients) > 0)
    {
        
?>
    Patient : <span style="margin-left:10px; padding-left:2px;"><select id="patient_id">
        <?php foreach($patients as $patient)
        {
            ?>
            <option value="<?php echo $patient['id']?>"><?php echo $patient['first_name']." ".$patient['last_name']?></option>
        <?php
        }
    
    ?>
            </select></span></br><?php
    }
    else
    {
        echo "There are no patients to be chosen";
    }
        ?>
    <div style="border:1px solid #ccc; background:#F7F7F7; padding:5px;">
    <div align="center" class="hide_record"><a href="#" id="patient_preview">View Patient Info</a> <div id="patient_info" style="display: none;"></div></div></div></br>
    Medicine : <textarea id="medicine" cols="30" rows="5"></textarea><br />
    Remarks : <textarea id="remarks" cols="30" rows="5"></textarea> <br /><br />
    <?php 
        if(isset($this->session->userdata['admin_info']['id']))
        {
            if(is_array($doctors) && count($doctors) > 0)
            {
            ?>
        Doctor : <span style="margin-left:10px; padding-left:2px;"><select id="doctor_id">
            <?php foreach($doctors as $doctor)
            {
                ?>
                <option value="<?php echo $doctor['id']?>"><?php echo $doctor['first_name']." ".$doctor['last_name']?></option>
            <?php
            }
            ?>
                </select></span><br /><br />
        <?php }
        }
        if(isset($this->session->userdata['secretary_info']['id']))
        {
            foreach($doctors as $doctor)
            {
                if($doctor['id'] == $this->session->userdata['secretary_info']['under_of'])
                {
            ?>
                    For Dr. <?php echo $doctor['first_name']." ".$doctor['last_name']?>
            <?php
                break;
                }
            }
        }
    else
    {
        echo "There are no doctors to select";
    }
    ?>
<a href="#finalize_prescription" class="fancybox pres_final_btn">Finalize prescription</a> </br>
</div>
</div>
<div id="finalize_prescription" style=" display: none; width: 500; height: 550">

</div>

<script>
    $(function(){
        $('#date').datepicker({});
    })
</script>

<script>
    $(window).load(function(){
        var form_data = {
            patient_id : $('#patient_id').val()
            //password : $('#password').val()
        };
        
        $.ajax({
                    url:"<?php echo base_url();?>admin/patient_preview",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#success').html(msg);
                    $('#patient_info').html(msg);
                    //window.location = window.location;
                    //alert(msg);
                        
                    }
                })
    });
    
    $('#patient_id').change(function(){
        var form_data = {
            patient_id : $(this).val()
            //password : $('#password').val()
        };
        
        $.ajax({
                    url:"<?php echo base_url();?>admin/patient_preview",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#success').html(msg);
                    $('#patient_info').html(msg);
                    //window.location = window.location;
                    //alert(msg);
                        
                    }
                })
    });
</script>

<script>
    $('#patient_preview').toggle(
                function(){ $(this).text('Hide Patient Info');$('#patient_info').show('slow');
                }
                ,function(){ $(this).text('View Patient Info'); $('#patient_info').hide('slow');
                }
            );
</script>

<script>
    $('.fancybox').click(function(){
        var form_data = {
            patient_id : $('#patient_id').val(),
            doctor_id : $('#doctor_id').val(),
            date : $('#date').val(),
            medicine : $('#medicine').val().trim(),
            remarks : $('#remarks').val().trim()
            //password : $('#password').val()
        };
        if(form_data['medicine'] == " " || form_data['medicine'] == "")
        {
            alert("Please fill out the medicine box");
            return false;
        }
        else if(form_data['remarks'] == " " || form_data['remarks'] == "")
        {
            alert("Please fill out the remarks");
            return false;
        }
        else if(form_data['remarks'] != " " && form_data['medicine'] != " ")
        {
            $.ajax({
                    url:"<?php echo base_url();?>admin/prescription_finalize",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                    //$('#success').html(msg);
                    $('#finalize_prescription').html(msg);
                    //window.location = window.location;
                    //alert(msg);   
                    }
                })
        }
    })
</script>
<script>
    $('.prescription_edit').click(function(){
        var form_data = {
            prescription_id : this.name
            //password : $('#password').val()
        };
        
        $.ajax({
                    url:"<?php echo base_url();?>admin/prescription_edit",
                    type: 'POST',
                    data: form_data,
                    success: function(msg){
                        $('#div_prescription_edit').html(msg);
                    }
                })
    })
</script>
<?php
    }
    else
    {
        echo "Please save a doctor and patient to the database";
    }
?>

