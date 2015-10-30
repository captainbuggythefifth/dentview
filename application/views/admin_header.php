<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<HTML>
    <HEAD>
        <TITLE><?php if (isset($title)) echo $title; else echo "DentView Dental Clinic"; ?></TITLE>
        <META NAME="Generator" CONTENT="TextPad 4.6">
        <META NAME="Author" CONTENT="?">
        <META NAME="Keywords" CONTENT="?">
        <META NAME="Description" CONTENT="?">



        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <!-- Add jQuery library -->
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/fancybox/lib/jquery-1.8.0.min.js"></script>

        <!-- Add mousewheel plugin (this is optional) -->
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

        <!-- Add fancyBox main JS and CSS files -->
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/fancybox/source/jquery.fancybox.js?v=2.1.0"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/javascript/fancybox/source/jquery.fancybox.css?v=2.1.0" media="screen" />

        <!-- Add Button helper (this is optional) -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>javascript/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.3" />
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.3"></script>

        <!-- Add Thumbnail helper (this is optional) -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>javascript/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.6" />
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.6"></script>

        <!-- Add Media helper (this is optional) -->
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.3"></script>

        <!-- end of fancy --> 
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/jQueryDatePicker/jquery-ui-1.10.0.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>javascript/jQueryDatePicker/jquery-ui-1.10.0.custom.js"></script>

        <link rel="stylesheet" href="<?php echo base_url() ?>css/tabs/jquery.ui.all.css">
        <script src="<?php echo base_url() ?>javascript/tabs/jquery.ui.core.js"></script>
        <script src="<?php echo base_url() ?>javascript/tabs/jquery.ui.widget.js"></script>
        <script src="<?php echo base_url() ?>javascript/tabs/jquery.ui.tabs.js"></script>

        <script src="<?php echo base_url() ?>javascript/dragNdrop/jquery.ui.droppable.js"></script>
        <script src="<?php echo base_url() ?>javascript/dragNdrop/jquery.ui.draggable.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>css/tabs/demos.css"> </link>

        <script src="<?php echo base_url() ?>javascript/noty/noty.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/ui/notification-ui.css"></link>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/noty/noty.css"></link>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/noty/fb.css"></link>


        <script src="<?php echo base_url() ?>javascript/form_validate.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/ui-lightness/jquery-ui-1.10.0.custom.css"></link>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/ui-lightness/jquery-ui-1.10.0.custom.min.css"></link>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/admin_css/style.css"></link>


        <link rel="stylesheet" href="<?php echo base_url() ?>css/superfish/superfish.css" media="screen">

        <script src="<?php echo base_url() ?>javascript/superfish/hoverIntent.js"></script>
        <script src="<?php echo base_url() ?>javascript/superfish/superfish.js"></script>


        <link rel="shortcut icon" href="<?php echo base_url() ?>images/icon.png" type="image/x-icon" />


        <script>
            jQuery(function(){
                jQuery('#example').superfish({
                    //useClick: true
                });
            });
                
                
            $(function() {
                $("#tabs").tabs();
    
                $( "#dialog" ).dialog({
                    autoOpen: false,
                    width: 400,
                    buttons: [
                        {
                            text: "Ok",
                            click: function() {
                                $( this ).dialog( "close" );
                            }
                        },
                        {
                            text: "Cancel",
                            click: function() {
                                $( this ).dialog( "close" );
                            }
                        }
                    ]
                });
                $( "#dialog-link" ).click(function( event ) {
                    $( "#dialog" ).dialog( "open" );
                    event.preventDefault();
                });
                $( "#draggable" ).draggable({ revert: "valid", containment : "parent", opacity : 0.60, cursor : "pointer"});
                //$( "#draggable2" ).draggable({ revert: "invalid" });

                $( "#droppable" ).droppable({
                    activeClass: "ui-state-hover",
                    hoverClass: "ui-state-active",
                    drop: function( event, ui ) {
                        var confirm = $('#email_add_hidden').val();
                        var security = $('#secure_all_fields').val();
                        if(confirm == "ok")
                        {
                            var email_add = $('#email_add').val();
                            var password = $('#password').val();
                            var first_name = $('#first_name').val();
                            var mi = $('#mi').val();
                            var mobile_number = $('#mobile_number').val();
                            var address = $('#address').val();
                            var last_name = $('#last_name').val();
                            var age = $('#age').val();
                            var occupation = $('#occupation').val();
                            if(email_add == "" || password == "" || first_name == "" || mi == "" || mobile_number == "" || address == "" || last_name == "" || age == "" || occupation == "")
                            {
                        
                                alert('Please fill out all the necessary information first');
                            }
                            else if(security == "not")
                            {
                                alert('There are some fields that needs to be secure.');
                            }
                            else if(email_add != "" || password != "" || first_name != "" || mi != "" || mobile_number != "" || address != "" || last_name != "" || age != "" || occupation != "")
                            {
                                $( this )
                                .find( "p" )
                                .removeClass("ui-state-highlight")
                                .html("")
                                .hide('slow')
                                //var a = document.myForms.email_add.value;
                            
                                //form_validate();
                                $('#sign_up_form').submit();
                            }
                    
                            //if(document.getElementById('password').disabled == true)
                            //var confirm = $('#email_add_hidden').val();
                            //document.getElementById('sign_up_button').disabled = false;
                            //$('#sign_up_form').submit();
                    
                        }
                        else if(confirm == "not")
                        {
                            alert("Please do clear out your email address because it has duplicate");
                        }
                        else
                        {
                            alert("Please input email address");
                        }
                        //var a = document.getElementById('draggable').hide('slow');
            
                                    
                    
                    }
          
                });
            });
        </script>




        <script type="text/javascript">
            $(document).ready(function() {
                /*
                 *  Simple image gallery. Uses default settings
                 */
                $('.fancybox_send_email').fancybox();
                $('.fancybox_resched').fancybox();
                $('.fancybox_cancellation').fancybox();
                $('.fancybox').fancybox();
                $('#fancybox_log_in').fancybox();
                $('#fancybox_sign_up').fancybox();
                $('#fancybox_reserve').fancybox();
                $('#admin_add_patient').fancybox();
                $('.fancybox_activate').fancybox();
                $('#fancybox_add_service').fancybox();
                $('.admin_edit').fancybox();
                $('.fancybox_view_patient_record').fancybox();
                $('.fancybox_view_patient_tooth_record').fancybox();
                $('.fancybox_view_patient_transaction').fancybox();
                $('.fancybox_history').fancybox();
                $('.fancybox_tooth_history').fancybox();
                $('.prescription_edit').fancybox();
                $('#make_new_prescription').fancybox();
                        
                $('#fancybox_add_secretary').fancybox();
                $('#patient_tooth').fancybox();
                $('.fancybox_edit_service').fancybox();
                        
                $('.fancybox_change_time').fancybox();
                        
                $('#fancybox_add_faq').fancybox();
                        
                $('#fancybox_doctor_notification').fancybox();
                // $('.admin_faq_deactivate').fancybox();
                $('.admin_faq_edit').fancybox();
                //$('#fancybox_reserve_logged').fancybox();

                /*
                 *  Different effects
                 */

                // Change title type, overlay closing speed
                $(".fancybox-effects-a").fancybox({
                    helpers: {
                        title : {
                            type : 'outside'
                        },
                        overlay : {
                            speedOut : 0
                        }
                    }
                });

                // Disable opening and closing animations, change title type
                $(".fancybox-effects-b").fancybox({
                    openEffect  : 'none',
                    closeEffect	: 'none',

                    helpers : {
                        title : {
                            type : 'over'
                        }
                    }
                });

                // Set custom style, close if clicked, change title type and overlay color
                $(".fancybox-effects-c").fancybox({
                    wrapCSS    : 'fancybox-custom',
                    closeClick : true,

                    openEffect : 'none',

                    helpers : {
                        title : {
                            type : 'inside'
                        },
                        overlay : {
                            css : {
                                'background' : 'rgba(238,238,238,0.85)'
                            }
                        }
                    }
                });

                // Remove padding, set opening and closing animations, close if clicked and disable overlay
                $(".fancybox-effects-d").fancybox({
                    padding: 0,

                    openEffect : 'elastic',
                    openSpeed  : 150,

                    closeEffect : 'elastic',
                    closeSpeed  : 150,

                    closeClick : true,

                    helpers : {
                        overlay : null
                    }
                });

                /*
                 *  Button helper. Disable animations, hide close button, change title type and content
                 */

                $('.fancybox-buttons').fancybox({
                    openEffect  : 'none',
                    closeEffect : 'none',

                    prevEffect : 'none',
                    nextEffect : 'none',

                    closeBtn  : false,

                    helpers : {
                        title : {
                            type : 'inside'
                        },
                        buttons	: {}
                    },

                    afterLoad : function() {
                        this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                    }
                });


                /*
                 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
                 */

                $('.fancybox-thumbs').fancybox({
                    prevEffect : 'none',
                    nextEffect : 'none',

                    closeBtn  : false,
                    arrows    : false,
                    nextClick : true,

                    helpers : {
                        thumbs : {
                            width  : 50,
                            height : 50
                        }
                    }
                });

                /*
                 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
                 */
                $('.fancybox-media')
                .attr('rel', 'media-gallery')
                .fancybox({
                    openEffect : 'none',
                    closeEffect : 'none',
                    prevEffect : 'none',
                    nextEffect : 'none',

                    arrows : false,
                    helpers : {
                        media : {},
                        buttons : {}
                    }
                });

                /*
                 *  Open manually
                 */

                $("#fancybox-manual-a").click(function() {
                    $.fancybox.open('1_b.jpg');
                });

                $("#fancybox-manual-b").click(function() {
                    $.fancybox.open({
                        href : 'iframe.html',
                        type : 'iframe',
                        padding : 5
                    });
                });

                $("#fancybox-manual-c").click(function() {
                    $.fancybox.open([
                        //					{
                        //						href : '1_b.jpg',
                        //						title : 'My title'
                        //					}, {
                        //						href : '2_b.jpg',
                        //						title : '2nd title'
                        //					}, {
                        //						href : '3_b.jpg'
                        //					}
<?php
if (isset($all_photos)) {
    foreach ($all_photos as $photo) {
        ?>
                                                                        {
                                                                            href : '<?php echo base_url() . $photo['source'] ?>',
                                                                            title: '<?php echo $photo['from_id'] ?>',
                                                                            alt:   '<?php echo $photo['from_id'] ?>'
                                                                        },
                                                                        //echo '{ href : '.$photo['source'].',title : '.$photo['name'].'},';
        <?php
    }
}
?>
                                                    ], {
                                                        helpers : {
                                                            thumbs : {
                                                                width: 75,
                                                                height: 50
                                                            }
                                                        }
                                                    });
                                                });

<?php
if (isset($services_with_photos))
    for ($i = 0;; $i++) {
        ?>
                                $(".fancybox-manual-<?php echo $services_with_photos[$i]['name_replaced'] ?>").click(function() {
                                    $.fancybox.open([
        <?php
        $photos = $services_with_photos[$i]['photo'];
        for ($j = 0;; $j++) {
            ?>
                                                                            {
                                                                                href : '<?php echo base_url() . $photos[$j]['source'] ?>',
                                                                                title: '<?php echo $photos[$j]['description'] ?>'
                                                       
                                                                            },
                                                    
            <?php
            if (!isset($photos[$j + 1])) {
                break;
            }
        }
        ?>
                                                            ], {
                                                                helpers : {
                                                                    thumbs : {
                                                                        width: 75,
                                                                        height: 50
                                                                    }
                                                                }
                                                            });
                                                        });


        <?php
        if (!isset($services_with_photos[$i + 1])) {
            break;
        }
    }
?>



                });
        </script>

    </HEAD>

