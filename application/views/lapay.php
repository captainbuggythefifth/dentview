<?php
if( !defined('BASEPATH') ) exit ('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="slider">
			<div class="slider-outer">
				<div class="slider-inner shell">
					<!-- Begin Slider Items -->
					<ul class="slider-items">
						<?php if (isset($all_photos)) {
									foreach($all_photos as $row) {?>
										<li>
											<img src="<?php echo base_url().$row['source']?>" alt="Slide Image" />
											<div class="slide-entry">
											
											</div>
											<a href="#" class="more" title="View More">View More</a>
										</li>
										<?php }
							 } ?>
					</ul>
					<!-- End Slider Items -->
					<div class="cl">&nbsp;</div>
					<div class="slider-controls">

					</div>
				</div>
			</div>
			<div class="cl">&nbsp;</div>
		</div>