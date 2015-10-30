<?php 
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
?>
<div id="div_edit_patient_record" style="display: none; width: 300; height: 300"></div>

<script>
    $(function() {
    $(".tab_record").tabs();
    })
</script>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if(isset($patient_record_info) && count($patient_record_info) > 0)
    {
     ?>
     <div id="bckgd">
     <div id="bckgd2">
     <div id="view_h_header"></div>
     <div class="bg_table" style="height:auto; margin:0 auto 0 auto; width: 450px; padding:10px;">
        Search History by Date : <input type="text" class="search_history" name="<?php echo $patient_record_info[0]['patient_id']?>">
        <div id="holder" align="center">
        <div class="tab_record" style="height:380; width:380; text-align:left;">
            <ul>
                <?php 
                    foreach($patient_record_info as $record)
                    {
                ?>
		<li><a href="#<?php echo $record['id']?>" class="ul_tab" name="<?php echo $record['id']?>"> <?php echo $record['date']?> </a></li>
                
                <?php }
                
                ?>
            </ul>
            <?php foreach($patient_record_info as $record)
                {
                ?>
                <div id="<?php echo $record['id'];?>">
                    Occlusion : <?php echo $record['occlusion']?> </br>
                    Periodical Condition : <?php echo $record['periodical_condition']?> </br>
                    Oral Hygiene : <?php echo $record['oral_hygiene']?> </br>
                    Denture Upper Since : <?php echo $record['denture_upper_since']?> </br>
                    Denture Lower Since : <?php echo $record['denture_lower_since']?> </br>
                    Abnormalities : <?php echo $record['abnormalities']?> </br>
                    General Condition : <?php echo $record['general_condition']?> </br>
                    Physician : <?php echo $record['physician']?> </br>
                    Nature of Treatment : <?php echo $record['nature_of_treatment']?> </br>
                    Allergies : <?php echo $record['allergies']?> </br>
                    Previous history of Bleeding : <?php echo $record['previous_history_of_bleeding']?> </br>
                    Chronic Ailments : <?php echo $record['chronic_ailments']?> </br>
                    Blood Pressure : <?php echo $record['blood_pressure']?> </br>
                    Drugs being Taken : <?php echo $record['drugs_being_taken']?> </br>
                    
                        
                   
                    <a href="#div_edit_patient_record" class="fancybox" name="<?php echo $record['id'];?>">Edit</a>
                    
                </div>
                
            <?php
                }
            ?>
        <a href="#" id="print" name="<?php echo $patient_record_info[0]['id']?>">Print</a></br>
        </div>
        
        <div id="rame" style=" display: none"></div>
        
        <script>
            $('#print').click(function(){
                var record_id = this.name
                var url = "<?php echo base_url()?>admin/record_print/"+record_id;
                 //var url = this.href;
                 $('#rame').html("<iframe src='"+url+"'></iframe>");
                 window.frames[0].print();
            })
        </script>
        
        <script>
            $('.ul_tab').click(function(){
                document.getElementById("print").name = this.name;
            })
        </script>
            <div class="hide_record"><a href="#" id="latest_record">Hide Latest Record</a></div>
            </div>
        <div id="searched"></div>
        
<?php
    }
?>
<div class="add_record" align="center"><a href="#" id="add_patient_record">Add another record for patient <?php echo $patient_info['first_name']." ".$patient_info['last_name']?></a></div><br />
                
    <div id="div_add_patient_record" style="display: none; padding-left:50px;">
        <input type="hidden" name="<?php echo $patient_info['id']?>" id="patient_id" value="<?php echo $patient_info['id']?>">
        Date : <span class="h_date"><input type="text" id="date_record"></span></br>
        Occlusion : <span class="h_occu"><input type="text" id="occlusion" value=""></span></br>
        Periodical Condition : <span class="h_pc"><input type="text" id="periodical_condition" value=""></span></br>
        Oral Hygiene : <span class="h_oral"><input type="text" id="oral_hygiene" value=""></span></br>
        Denture Upper Since : <span class="h_dhs"><input type="text" id="denture_upper_since" value=""></span></br>
        Denture Lower Since : <span class="h_dls"><input type="text" id="denture_lower_since" value=""></span></br>
        Abnormalities : <span class="h_abnor"><input type="text" id="abnormalities" value=""></span></br>
        General Condition : <span class="h_gencon"><input type="text" id="general_condition" value=""></span></br>
        Physician : <span class="h_phys"><input type="text" id="physician" value=""></span></br>
        Nature Of Treatment : <span class="h_nature"><input type="text" id="nature_of_treatment" value=""></span></br>
        Allergies : <span class="h_allergies"><input type="text" id="allergies" value=""></span></br>
        Previous History of Bleeding : <span class="h_phb"><input type="text" id="previous_history_of_bleeding" value=""></span></br>
        Chronic Ailments : <span class="h_chronic"><input type="text" id="chronic_ailments" value=""></span></br>
        Blood Pressure : <span class="h_blood"><input type="text" id="blood_pressure" value=""></span></br>
        Drugs Being Taken : <span class="h_drug"><input type="text" id="drugs_being_taken" value=""></span></br>
        <input type="button" id="button_add_record" value="Add" class="h_btn_add">

<div id="view_h_footer"></div>
    </div>
</div>
</div>
</div>
    <script>
        $('#add_patient_record').click(function(){
            //$('#patient_record_does_not_exist').hide('slow');
            $('#div_add_patient_record').show('slow');
        })
    </script>

    <script>
        $('#button_add_record').click(function(){
            var form_data = {
                patient_id : $('#patient_id').val(),
                date : $('#date_record').val(),
                occlusion : $('#occlusion').val(),
                periodical_condition : $('#periodical_condition').val(),
                oral_hygiene : $('#oral_hygiene').val(),
                denture_upper_since : $('#denture_upper_since').val(),
                denture_lower_since : $('#denture_lower_since').val(),
                abnormalities : $('#abnormalities').val(),
                general_condition : $('#general_condition').val(),
                physician : $('#physician').val(),
                nature_of_treatment : $('#nature_of_treatment').val(),
                allergies : $('#allergies').val(),
                previous_history_of_bleeding : $('#previous_history_of_bleeding').val(),
                chronic_ailments : $('#chronic_ailments').val(),
                blood_pressure : $('#blood_pressure').val(),
                drugs_being_taken : $('#drugs_being_taken').val()
            }
            //alert(form_data['occlusion']);
            $.ajax({
                url : "<?php echo base_url()?>admin/record_add",
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

    <script>
        $(function() {
        $( "#date_record" ).datepicker({});
        $( ".search_history" ).datepicker({});

      });
    </script>

    <script>
        $('.fancybox').click(function(){
            var form_data = {
                record_id : this.name
            }

            $.ajax({
                url : "<?php echo base_url()?>admin/record_edit",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('#div_edit_patient_record').html(msg);
                }
            })
        })
    </script>

    <script>
        $('.search_history').change(function(){
            var form_data = {
                patient_id : this.name,
                date : $(this).val()
                //data : $('.tab_record').html()
            }

            $.ajax({
                url : "<?php echo base_url()?>admin/search_history",
                type : "POST",
                data : form_data,
                success : function(msg){
                    $('.tab_record').slideUp('slow');
                    $('#searched').html(msg);
                    
                }
            })

        });


    </script>
    <script>
        $('#latest_record').toggle(function(){
            $('.tab_record').slideUp('slow'),
            $(this).text("Show Latest Record")
        }, function(){
            $('.tab_record').slideDown('slow'),
            $(this).text("Hide Latest Record")
        })
    </script>



