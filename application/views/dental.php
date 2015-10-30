<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script>
    $(window).load(function(){
<?php
if (isset($wrong_sign_up)) {
    ?>
                $.fancybox.open('#sign_up');
<?php } ?>
    });
</script>


<script>
    $(window).load(function(){
<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "np") {
        ?>
                            $.fancybox.open('#new_patient');
                            setTimeOut(function(){
                                window.location = "<?php echo base_url() ?>"
                            },2000);
        <?php
        if ($_GET['msg'] == "swwdr") {
            ?>
                                $.fancybox.open('#sign_up');
            <?php
        }
    } else {
        ?>
                    $.fancybox.open('#log_in');
    <?php }
}
?>
    });
</script>


<script type="text/javascript" src="jquery.js"></script>
<script>
    var tmp=0;

    function add(){
        window.location="add.php";
    }

    $(document).ready(function(){
        var count=3;


        document.getElementById(0).style.border="solid 2px green";
        $('#slide_me').animate({"scrollTop":tmp*300});

        $('.thumbnail').click(function(){

            clean(this.id);
            $('#slide_me').animate({"scrollTop":this.id*300});

            tmp=this.id;
            global=tmp;
        });


        $('.aa').click(function(){

            if(this.id=="prev" && tmp == 0){
                tmp = count;
            }else if(this.id=="prev" && this.id != 0){
                tmp--;
            }

            if(this.id=="next" && tmp < count){
                tmp++;
            }else if(this.id=="next"){
                tmp = 0;
            }

            clean(tmp);

            $('#slide_me').animate({"scrollTop":tmp*300});
            global=tmp;


        });

        function clean(n){
            for(x=0;x<4;x++){
                if(x != n)
                    document.getElementById(x).style.border="solid 2px lightblue";
                else
                    document.getElementById(x).style.border="solid 2px green";

            }
        }

    });
</script>

<script>
    $(document).ready(function(){


        setInterval(function(){
            if(tmp<3)
                tmp++;
            else
                tmp=0;

            $('#slide_me').animate({"scrollTop":tmp*300});

            clean(tmp)},5000);

        function clean(n){
            for(x=0;x<4;x++){
                if(x != n)
                    document.getElementById(x).style.border="solid 2px lightblue";
                else
                    document.getElementById(x).style.border="solid 2px green";

            }
        }
    });
</script>



<?php
$link_for_reserve = '#link_for_reserve';
if (isset($this->session->userdata['patient_info']['id'])) {
    //$link_for_reserve = base_url().'patient-reservation';
    $link_for_reserve = '#link_load_reservation';
}
?>
<body>
    <div id="main_banner">
        <div class="header">

            <div id="logo">
                <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>images/logo.png" title="DentView Dental Clinic" width="320" height="67" border="0" alt="DentView Dental Clinic"/></a></div>

            <div class="right_header">
                <div class="top_menu">
<?php
if (!isset($this->session->userdata['patient_info']['id'])) {
    ?>
                        <a id="fancybox_log_in" class="login" href="#log_in" title="Log in">login</a> 
                        <a id="fancybox_sign_up" class="sign_up" href="#sign_up" title="Sign up">signup</a>

                        <?php
                    } else {
                        ?>
                        <a id="fancybox_log_in" class="login" href="<?php echo base_url() ?>patient-profile" title="My profile">profile</a> 
                        <a id="fancybox_sign_up" class="sign_up" href="<?php echo base_url() ?>patient-log-out" title="Log out">log out</a> 
                        <?php
                    }
                    ?>
                </div>
                <div id="menu">
                    <ul>
                        <li><a id="current"  style="color:#68C2EF; margin: -5px 0;" href="<?php echo base_url() ?>">Home</a></li>
                        <li><a id="patient-view-all-doctors" href="<?php echo base_url() ?>patient-view-all-doctors">Doctors</a></li>
                        <li><a id="patient-services" href="<?php echo base_url() ?>patient-services">Services</a></li>
                        <li><a href="#div_contact_us" id="contact_us">Contact Us</a></li>
                        <li><a id="patient-services" href="<?php echo base_url() ?>faq">F.A.Q</a></li>

                    </ul>
                </div>


            </div>
        </div>


        <div id="middle_box">

            <div id="slide_me">

                <div id="slider">
                    <img src="images/banner/banner1.jpg" />
                </div>

                <div id="slider">
                    <img src="images/banner/banner2.jpg" />
                </div>

                <div id="slider">
                    <img src="images/banner/banner3.jpg" />
                </div>

                <div id="slider">
                    <img src="images/banner/banner4.jpg" />
                </div>


            </div>
        </div>

        <br>
        <div id="images">

            <img class="aa" style="float:left;cursor:pointer;margin-left:50px;margin-top:-15px;" src="images/arrow2.png" id="prev"/>
            <img class="aa" style="float:right;cursor:pointer;margin-right:50px;margin-top:-15px;" src="images/arrow1.png " id="next"/>
            <center>
                <img class="thumbnail" src="images/banner/banner1.jpg" id="0" />
                <img class="thumbnail" src="images/banner/banner2.jpg" id="1"/>
                <img class="thumbnail" src="images/banner/banner3.jpg" id="2"/>
                <img class="thumbnail" src="images/banner/banner4.jpg" id="3" />
            </center>
        </div>
    </div>

    <div id="main_content">
        <div class="box_content">
            <div class="box_title">
                <div class="title_icon"><img src="<?php echo base_url() ?>images/mini_icon1.gif"  /></div>
                <h2>My <span class="dark_blue">Services</span></h2>
            </div>
            <div class="box_text_content"><!-- <img src="<?php echo base_url() ?>images/calendar.gif" alt="" class="box_icon" />-->
                <div class="box_img" align="center">
                    <img src="<?php echo base_url(); ?>images/sample.jpg" title="teeth whitening"/>	
                </div>
            </div>
          <div class="box_text_content"> <!--<img src="images/calendar.gif" alt="" class="box_icon" />-->
                <div class="box_text">
                    <div class="box_list">
                        <ul>
<?php
if (isset($services_with_photos)) {
    $i = 0;
    foreach ($services_with_photos as $service) {
        $str = str_ireplace(" ", "-", $service['name']);
        ?>


                                    <li><img src="<?php echo base_url(); ?>images/checked.gif"><a style="cursor:pointer" class="fancybox-manual-<?php echo $str ?>"><?php echo $service['name'] ?></a></li>
                                    <?php
                                    $i++;
                                    if ($i == 3)
                                        break;
                                }
                            }
                            ?>
                        </ul> 
                    </div>
                    <div class="box_list2">
                        <ul>
                            <?php
                            for ($i = 3; $i < 6; $i++) {
                                $str = str_ireplace(" ", "-", $services_with_photos[$i]['name']);
                                ?>


                                <li><img src="<?php echo base_url(); ?>images/checked.gif"><a style="cursor:pointer" class="fancybox-manual-<?php echo $str ?>"><?php echo $services_with_photos[$i]['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul> 
                    </div>
                </div>
                <a href="#" class="details">+ details</a> </div>
        </div>
        <div class="box_content">
            <div class="box_title">
                <div class="title_icon"><img src="<?php echo base_url() ?>images/mini_icon2.gif" alt="" /></div>
                <div id="our_goals"><h2>Our <span class="dark_blue"> Goals</span></h2></div>
            </div>

            <div class="box_text_content">
                <div class="box_img" align="center"> 
                    <a href="#"><img src="<?php echo base_url() ?>images/icon/smile3.png" title="smile lang gud"></a>
                </div>
            </div>
            <div class="box_text_content">
                <div class="box_text"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </div>
                <a href="#" class="details">+ details</a> </div>
        </div>

        <div class="box_content">
            <div class="box_title">
                <div class="title_icon"><img src="<?php echo base_url() ?>images/mini_icon3.gif" alt="" /></div>
                <h2>Contact <span class="dark_blue">Information</span></h2>
            </div>
            <div class="box_text_content"> <!--<img src="<?php echo base_url() ?>images/checked.gif" alt="" class="box_icon" />-->
                <div class="box_img" align="center">
                    <div class="fancybox-effects-b" href="<?php echo base_url(); ?>images/location.png" title="Location of Dentview Dental Clinic">
                        <img   src="<?php echo base_url(); ?>images/location.png" title="Location of Dentview Dental Clinic"/>
                    </div>
                </div>
            </div>
           <div class="box_text_content"> <!--<img src="<?php echo base_url() ?>images/checked.gif" alt="" class="box_icon" />-->
                <div class="box_contact">

                    <div class="box_list3">
                        <ul>
                            <li>Tel. No.:512-2493</li>
                            <li> Cel.No. 0920-73043313</li>
                            <li>E-mail: drjtaytayan@yahoo.com</li>
                            <li>Address: APM Shopping Mall Soriano Avenue<br> Cebu North Reclamation Area Cebu City, <br>Philippines</li>

                        </ul> 
                    </div>
                </div>
                <a href="#" class="details">+ details</a> </div>
        </div>
        <div class="clear"></div>
    </div>


    <div id="footer" style="margin:auto;">
        <div class="copyright"> <img src="" alt=""/> </div>
        <div class="center_footer">&copy; Dentview dental clinic 2013. All Rights Reserved</div>
        <div class="footer_links"> <a href=""><img src="" alt="" border="0" /></a> </div>
    </div>








    <!--<li><a class="fancybox" href="#inline1" title="Lorem ipsum dolor sit amet">Inline</a></li> -->

</body>
<div id="new_patient" style=" display: none; width: 300; height: auto">
    <div class="bg_table" style="padding:10px; height:auto;">
        <center><div style="padding: 20px;">Your confirmation number was sent to your email address. Please do type it in the log in form. Thank you!
        </center></div>
</div>
</div>

<div id="link_for_reserve" style="width:400px;display: none;">
    <div class="bg_table" style="padding:10px; height:320px;">
        Please do log in or sign up first to access this page.
    </div>
</div>

<div id="link_load_reservation" style="height:600; width:400px;display: none;">
    <div style="height:100;"><div id="click_to_load"><center><h3>RESERVE</h3></center></div></div>
    <div style="height:100;"><div id="img_loader" style="display: none; z-index: 0"> <img src="<?php base_url() ?>images/loading.gif" style="width: 20; height: 20"> </div>
        <div id="loader"> </div>

    </div>

</html>
<script>
    $('#loader').ajaxComplete(function(){
        $('#img_loader').hide();
    });
</script>
<script>
    $('#click_to_load').live('click',function(){
        $('#img_loader').show();
        //$(this).fadeOut(1000);
        var form_data = {
            is_reservation : true
        }
        //$(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url(); ?>patient-load-reservation-page",
            type: 'POST',
            data: form_data,
            success: function(msg){
                $('#loader').html(msg);
            }
        })
    });
</script>


<script>
    $('patient_exist_log_in').click(function(){
        $('patient_exist').hide('slow');
        $('log_in').show('slow');
    });
</script>

<script>
    $('change_email_add').click(function(){
        $('patient_exist').hide('slow');
        $('sign_up').show('slow');
    });
</script>
<script>
    $("img").error(function(){
        $(this).hide();
        //alert('asdfh');
    });
</script>

<script>
    $('#middle_box').error(function(){
        $(this).html("<div id='slide_me'><div id='slider'><img src='images/banner1.png' /></div><div id='slider'><img src='images/banner2.jpg' /></div><div id='slider'><img src='images/banner3.jpg' /></div><div id='slider'><img src='images/banner4.jpg' /></div></div>");
    })
</script>




