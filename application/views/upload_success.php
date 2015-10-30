<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<html>
<head>
<title>Upload Form</title>
</head>
<body>
<script>
    $(document).ready(function(){
        alert("Your file was successfully uploaded!");
        window.location="<?php echo base_url()?>admin/upload/service/27";
    })
</script>
<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('administer-upload', 'Upload Another File!'); ?></p>

</body>
</html>
