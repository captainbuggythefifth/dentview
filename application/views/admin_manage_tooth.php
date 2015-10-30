<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    $(function(){
            $( ".draggable" ).draggable({ revert: "valid" });

            $( ".droppable" ).droppable({
                        activeClass: "ui-state-hover",
                        hoverClass: "ui-state-active",
                        drop: function( event, ui ) {
                            var text = ui.draggable.text();
                            //var close = "<div class='close'>x</div>";
                            var pText = $(this).find('input').val();

                            $(this).find('input').val(pText + text);
                        }
        })
    })
</script>
<script>
    $('.close').live('click',function(){
        $(this).parent().remove();
    })
</script>
<script>
    $(function() {
    $( "#date,#date_child,#date_tooth_child_hidden" ).datepicker({});
    });
</script>

<div id="div_display_tooth_child" style="  display:inline-block;" align="center">
<div class="draggable" style='width:78;height:25;background-color: #CEFFFF; float:left; border:1px solid #ccc;' id="draggable1" name="RF">  RF  </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable2" name="LC"> LC </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable3" name="Ag"> Ag </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable4" name="FC"> FC </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable5" name="M"> M </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable6" name="PJC"> PJC </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable7" name="AJC"> AJC </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable8" name="RPD"> RPD </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable9" name="CD"> CD </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable10" name="PFB"> PFB </div>
<div class="draggable" style='width:78;height:25;background-color:#CEFFFF; float:left; border:1px solid #ccc;' id="draggable11" name="AFB"> AFB </div>
</div>
</br>
</br>
</br>


<?php
    if(isset($tooth_adult_info))
    {
        
?>
        <input type="hidden" value="<?php echo $patient_id;?>" id="patient_id">
        
        Date : <input type="text" id="date">
        
 <div id="tooth_container">       
 	<div class="tooth_wrap">
        <ul>
        
        <li><div class="droppable" id="droppable2" style="border:1px solid #ccc; " >
        <img src="<?php echo base_url()?>images/tooth2/18.png" height="40" width="40">
        <div style="background-color: #CEFFFF;"> Tooth 18 </div>
        <input type="text" id="18" value="<?php echo $tooth_adult_info['18']?>">
        </div></li>
        
        <li><div class="droppable" id="droppable2" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/17.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 17 </div>
        <input type="text" id="17" value="<?php echo $tooth_adult_info['17']?>">
        </div></li>

        <li><div class="droppable" id="droppable3" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/16.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 16 </div>
        <input type="text" id="16" value="<?php echo $tooth_adult_info['16']?>">
        </div></li>

        <li><div class="droppable" id="droppable4" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/15.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 15 </div>
        <input type="text" id="15" value="<?php echo $tooth_adult_info['15']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/14.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 14 </div>
        <input type="text" id="14" value="<?php echo $tooth_adult_info['14']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/13.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 13 </div>
        <input type="text" id="13" value="<?php echo $tooth_adult_info['13']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/12.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 12 </div>
        <input type="text" id="12" value="<?php echo $tooth_adult_info['12']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/11.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 11 </div>
        <input type="text" id="11" value="<?php echo $tooth_adult_info['11']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/21.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 21 </div>
        <input type="text" id="21" value="<?php echo $tooth_adult_info['21']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
         <img src="<?php echo base_url()?>images/tooth2/22.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 22 </div>
        <input type="text" id="22" value="<?php echo $tooth_adult_info['22']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/23.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 23 </div>
        <input type="text" id="23" value="<?php echo $tooth_adult_info['23']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/24.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 24 </div>
        <input type="text" id="24" value="<?php echo $tooth_adult_info['24']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/25.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 25 </div>
        <input type="text" id="25" value="<?php echo $tooth_adult_info['25']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/26.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 26 </div>
        <input type="text" id="26" value="<?php echo $tooth_adult_info['26']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/27.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 27 </div>
        <input type="text" id="27" value="<?php echo $tooth_adult_info['27']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/28.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 28 </div>
        <input type="text" id="28" value="<?php echo $tooth_adult_info['28']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/48.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 48 </div>
        <input type="text" id="48" value="<?php echo $tooth_adult_info['48']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/47.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 47 </div>
        <input type="text" id="47" value="<?php echo $tooth_adult_info['47']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/46.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 46 </div>
        <input type="text" id="46" value="<?php echo $tooth_adult_info['46']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/45.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 45 </div>
        <input type="text" id="45" value="<?php echo $tooth_adult_info['45']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/44.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 44 </div>
        <input type="text" id="44" value="<?php echo $tooth_adult_info['44']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/43.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 43 </div>
        <input type="text" id="43" value="<?php echo $tooth_adult_info['43']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/42.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 42 </div>
        <input type="text" id="42" value="<?php echo $tooth_adult_info['42']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/41.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 41 </div>
        <input type="text" id="41" value="<?php echo $tooth_adult_info['41']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/31.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 31 </div>
        <input type="text" id="31" value="<?php echo $tooth_adult_info['31']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/32.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 32 </div>
        <input type="text" id="32" value="<?php echo $tooth_adult_info['32']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/33.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 33 </div>
        <input type="text" id="33" value="<?php echo $tooth_adult_info['33']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/34.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 34 </div>
        <input type="text" id="34" value="<?php echo $tooth_adult_info['34']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/35.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 35 </div>
        <input type="text" id="35" value="<?php echo $tooth_adult_info['35']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/36.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 36 </div>
        <input type="text" id="36" value="<?php echo $tooth_adult_info['36']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/37.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 37 </div>
        <input type="text" id="37" value="<?php echo $tooth_adult_info['37']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/38.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 38 </div>
        <input type="text" id="38" value="<?php echo $tooth_adult_info['38']?>">
        </div></li>
        </ul>
        <input type="button" id="button_save_tooth" value="Save" class="p_btn">
  	</div>
  </div>      
        
        <script>
    $('#button_save_tooth').click(function(){
        var form_data = {
            patient_id : $('#patient_id').val(),
            date : $('#date').val(),
            18 : $('#18').val(),
            17 : $('#17').val(),
            16 : $('#16').val(),
            15 : $('#15').val(),
            14 : $('#14').val(),
            13 : $('#13').val(),
            12 : $('#12').val(),
            11 : $('#11').val(),
            21 : $('#21').val(),
            22 : $('#22').val(),
            23 : $('#23').val(),
            24 : $('#24').val(),
            25 : $('#25').val(),
            26 : $('#26').val(),
            27 : $('#27').val(),
            28 : $('#28').val(),
            48 : $('#48').val(),
            47 : $('#47').val(),
            46 : $('#46').val(),
            45 : $('#45').val(),
            44 : $('#44').val(),
            43 : $('#43').val(),
            42 : $('#42').val(),
            41 : $('#41').val(),
            31 : $('#31').val(),
            32 : $('#32').val(),
            33 : $('#33').val(),
            34 : $('#34').val(),
            35 : $('#35').val(),
            36 : $('#36').val(),
            37 : $('#37').val(),
            38 : $('#38').val()
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/tooth_adult_save",
            type : "POST",
            data : form_data,
            success : function(msg){
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
        //alert(form_data['18']);
    })
</script>

<?php
    }
?>
        
        
        <?php
    if(isset($tooth_child_info))
    {
        
?>
        
        <input type="hidden" value="<?php echo $patient_id;?>" id="patient_id">
        
        Date : <input type="text" id="date_child" >
    <div id="tooth_container">       
 	<div class="tooth_wrap">
        <ul>
        
        <li><div class="droppable" id="droppable2" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/55.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 55 </div>
        <input type="text" id="55" value="<?php echo $tooth_child_info['55']?>">
        
        </div></li>
        
        <li><div class="droppable" id="droppable2" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/54.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 54 </div>
        <input type="text" id="54" value="<?php echo $tooth_child_info['54']?>">
        </div></li>

        <li><div class="droppable" id="droppable3" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/53.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 53 </div>
        <input type="text" id="53" value="<?php echo $tooth_child_info['53']?>">
        </div></li>

        <li><div class="droppable" id="droppable4" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/52.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 52 </div>
        <input type="text" id="52" value="<?php echo $tooth_child_info['52']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/51.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 51 </div>
        <input type="text" id="51" value="<?php echo $tooth_child_info['51']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/61.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 61 </div>
        <input type="text" id="61" value="<?php echo $tooth_child_info['61']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/62.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 62 </div>
        <input type="text" id="62" value="<?php echo $tooth_child_info['62']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/63.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 63 </div>
        <input type="text" id="63" value="<?php echo $tooth_child_info['63']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/64.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 64 </div>
        <input type="text" id="64" value="<?php echo $tooth_child_info['64']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/65.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 65 </div>
        <input type="text" id="65" value="<?php echo $tooth_child_info['65']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/85.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 85 </div>
        <input type="text" id="85" value="<?php echo $tooth_child_info['85']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/84.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 84 </div>
        <input type="text" id="84" value="<?php echo $tooth_child_info['84']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/83.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 83 </div>
        <input type="text" id="83" value="<?php echo $tooth_child_info['83']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/82.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 82 </div>
        <input type="text" id="82" value="<?php echo $tooth_child_info['82']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/81.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 81 </div>
        <input type="text" id="81" value="<?php echo $tooth_child_info['81']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/71.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 71 </div>
        <input type="text" id="71" value="<?php echo $tooth_child_info['71']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/72.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 72 </div>
        <input type="text" id="72" value="<?php echo $tooth_child_info['72']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/73.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 73 </div>
        <input type="text" id="73" value="<?php echo $tooth_child_info['73']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/74.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 74 </div>
        <input type="text" id="74" value="<?php echo $tooth_child_info['74']?>">
        </div></li>

        <li><div class="droppable" style="border:1px solid #ccc;">
        <img src="<?php echo base_url()?>images/tooth2/75.png" height="40" width="40">
        <div style="background-color: #CEFFFF; width: 80"> Tooth 75 </div>
        <input type="text" id="75" value="<?php echo $tooth_child_info['75']?>">
         </div></li>
        </ul>
        
        <input type="button" id="button_save_tooth_child" value="Save" class="t_btn"/>
      </div>
  </div>
        <script>
    $('#button_save_tooth_child').click(function(){
        var form_data = {
            patient_id : $('#patient_id').val(),
            date : $('#date').val(),
            55 : $('#55').val(),
            54 : $('#54').val(),
            53 : $('#53').val(),
            52 : $('#52').val(),
            51 : $('#51').val(),
            61 : $('#61').val(),
            62 : $('#62').val(),
            63 : $('#63').val(),
            64 : $('#64').val(),
            65 : $('#65').val(),
            85 : $('#85').val(),
            84 : $('#84').val(),
            83 : $('#83').val(),
            82 : $('#82').val(),
            81 : $('#81').val(),
            71 : $('#71').val(),
            72 : $('#72').val(),
            73 : $('#73').val(),
            74 : $('#74').val(),
            75 : $('#75').val()
        }
        $.ajax({
            url : "<?php echo base_url()?>admin/tooth_child_save",
            type : "POST",
            data : form_data,
            success : function(msg){
                noty({type:"notification",text:msg});
                window.setTimeout(function(){
                        window.location = window.location;
                    }, 2000);
            }
        })
        //alert(form_data['55']);
    })
</script>
    
    <script>
        $('#edit_tooth_child').toggle(function(){
            $(this).text("Hide editing tooth")
            $('#div_edit_tooth_child').show('slow'),
            $('#div_display_tooth_child').slideUp('slow')
        }, function(){
            $(this).text("Edit")
            $('#div_edit_tooth_child').hide('slow'),
            $('#div_display_tooth_child').slideDown('slow')
        })
    </script>
<?php
    }
?>



