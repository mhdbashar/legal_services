<?php
defined('BASEPATH') or exit('No direct script access allowed');
echo '<link href="' . base_url('modules/babil_multi_theme/assets/sidebar.css') . '" rel="stylesheet" type="text/css" >';
?>

<button type="button" class="show color_confi_btn"><i class="fa fa-cog" aria-hidden="true"></i></button>
<div class="slideout_color_Confi my_sidebar">
	<button type="button" class="hide_close_btn con_close_btn"><i class="fa fa-times" aria-hidden="true"></i></button>
	<h1>Multi Theme <i class="fa fa-cog" aria-hidden="true"></i></h1>
	<p>THEME BASE</p>
	<ul class="list-unstyled">
		<?php
			$current_theme = current_theme_applied();
		 ?>
		<li>
			<h3 style="background-color: #415165;" id="default_mode"><span><?= !$current_theme ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Default Color</h3>
		</li>

		<li>
			<h3 style="background-color: #131c28" id="dark_mode"><span><?=$current_theme && $current_theme=='dark' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Dark mode</h3>
		</li>

		<li>
			<h3 style="background-color: #ffffff; color: black" id="light_mode"><span><?=$current_theme && $current_theme=='light' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Light Mode </h3>
		</li>

		<li>
			<h3 style="background-color: #9dc02e" id="green_mode"><span><?=$current_theme && $current_theme=='green' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>green</h3>
		</li>
		<li>
			<h3 style="background-color: #006dd4" id="purple_mode"><span><?=$current_theme && $current_theme=='purple' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Purple</h3>
		</li>
		
			<li>
			<h3 style="background-color: #5e3030" id="brown_mode"><span><?=$current_theme && $current_theme=='brown' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Brown</h3>
		</li>
			<li>
			<h3 style="background-color: #b1976b" id="bbrown_mode"><span><?=$current_theme && $current_theme=='bbrown' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Gold</h3>
		</li>
			<li>
			<h3 style="background-color: #3c3e62" id="gray_mode"><span><?=$current_theme && $current_theme=='Gray' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Gray</h3>
		</li>
		
			<li>
			<h3 style="background-color: #bf0000" id="red_mode"><span><?=$current_theme && $current_theme=='red' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>Red</h3>
		</li>
			<li>
			<h3 style="background-color: #f4b50e" id="orange_mode"><span><?=$current_theme && $current_theme=='orange' ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '' ?> </span>orange</h3>
		</li>
		
		
	</ul>
</div>

<script>
	$('.show').click(function() {
		$('.slideout_color_Confi').addClass('on');
		$('body').css('overflow','hidden');
	});
	$('.hide_close_btn').click(function() {
		$('.slideout_color_Confi').removeClass('on');
		$('body').css('overflow','');
	});
	$('#dark_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"dark"},function(resp){
			$('#theme_styles_color').remove();
			$('#light_styles_color').remove();
			$('#purple_styles_color').remove();
			$('#green_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
			$('#red_styles_color').remove();
			$('#orange_styles_color').remove();
				$('#gray_styles_color').remove();
			$('head').append('<link id="dark_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/dark-css/dark_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		});
	});
	$('#light_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"light"},function(resp){
			$('#dark_styles_color').remove();
			$('#theme_styles_color').remove();
			$('#purple_styles_color').remove();
			$('#green_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
				$('#gray_styles_color').remove();
				$('#orange_styles_color').remove();
			$('head').append('<link id="light_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/light-css/light_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		});
	});

	$('#default_mode').click(function() {

		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:null},function(resp){
			$('#dark_styles_color').remove();
			$('#purple_styles_color').remove();
			$('#green_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
			$('#light_styles_color').remove();
			$('#red_styles_color').remove();
			$('#orange_styles_color').remove();
				$('#gray_styles_color').remove();
		})
	});

	$('#green_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"green"},function(resp){
			$('#theme_styles_color').remove();
			$('#dark_styles_color').remove();
			$('#light_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
				$('#gray_styles_color').remove();
				$('#red_styles_color').remove();
				$('#orange_styles_color').remove();
			$('head').append('<link id="green_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/green-css/green_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})
	});
	
		$('#brown_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"brown"},function(resp){
			$('#theme_styles_color').remove();
			$('#dark_styles_color').remove();
			$('#light_styles_color').remove();
				$('#green_styles_color').remove();
					$('#gray_styles_color').remove();
					$('#bbrown_styles_color').remove();
					$('#red_styles_color').remove();
					$('#orange_styles_color').remove();
			$('head').append('<link id="brown_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/brown-css/brown_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})
	});
	
	

	$('#purple_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"purple"},function(resp){
			$('#theme_styles_color').remove();
			$('#dark_styles_color').remove();
			$('#green_styles_color').remove();
			$('#light_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#gray_styles_color').remove();
			$('#bbrown_styles_color').remove();
			$('#red_styles_color').remove();
			$('#orange_styles_color').remove();
			$('head').append('<link id="purple_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/purple-css/purple_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})

	});
	
		$('#bbrown_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"bbrown"},function(resp){
			$('#theme_styles_color').remove();
			$('#dark_styles_color').remove();
			$('#green_styles_color').remove();
			$('#light_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#gray_styles_color').remove();
			$('#red_styles_color').remove();
			$('#orange_styles_color').remove();
			
			$('head').append('<link id="bbrown_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/bbrown-css/bbrown_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})

	});
			$('#gray_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"gray"},function(resp){
			$('#theme_styles_color').remove();
			
			$('#dark_styles_color').remove();
			$('#green_styles_color').remove();
			$('#light_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
			$('#red_styles_color').remove();
			$('#orange_styles_color').remove();
			$('head').append('<link id="bbrown_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/gray-css/gray_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})

	});
	
	
			$('#red_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"red"},function(resp){
			$('#theme_styles_color').remove();
			
			$('#dark_styles_color').remove();
			$('#green_styles_color').remove();
			$('#light_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
			$('#orange_styles_color').remove();
			$('head').append('<link id="red_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/red-css/red_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})

	});
	
			$('#orange_mode').click(function() {
		$('.fa-check-square-o').remove();
		$(this).find('span').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> ');
		$.get(admin_url+'babil_multi_theme/main/update_color',{theme_css:"orange"},function(resp){
			$('#theme_styles_color').remove();
			
			$('#dark_styles_color').remove();
			$('#green_styles_color').remove();
			$('#light_styles_color').remove();
			$('#brown_styles_color').remove();
			$('#bbrown_styles_color').remove();
			$('head').append('<link id="orange_styles_color" href="<?=base_url('modules/babil_multi_theme/assets/orange-css/orange_styles.css?v='.time());?>" rel="stylesheet" type="text/css">');
		})

	});
	
	
	
	
</script>