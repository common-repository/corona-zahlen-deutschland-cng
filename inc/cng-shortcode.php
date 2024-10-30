<?php

function cng_shortcode_callback($atts)
{
	$atts = shortcode_atts( array(
	), $atts, 'cng_shortcode' );
 
	
	$cng_shortcode=new CNG_SHORTCODE();
	
	return $cng_shortcode->draw(); 
}
add_shortcode( 'cng', 'cng_shortcode_callback' );




class CNG_SHORTCODE extends CNG_ABSTRACT implements CNG_INTERFACE{
	function __construct(){
		parent::__construct();
		//custom stuff
	}
	
	function draw(){
		$data=$this->data;
		wp_enqueue_style('cng_shortcode_styles');
		if(key_exists("eigenes_css",$this->settings)){
			$inlineCss= $this->settings["eigenes_css"];
			wp_add_inline_style("cng_shortcode_styles",$inlineCss);
		}
		
		ob_start();
		?>
		<div class="cng-shortcode">
			<h2>Corona in Deutschland</h2>
			
			<div><?php echo $this->getCoronaDays()." Tage" ?> (<?php echo $this->getCoronaTime() ?>)</div>
			<div><?php echo $data["cases"]?> Fälle (<?php echo $this->pos_neg_draw_helper($data["delta"]["cases"])?>)</div>
			<div><?php echo $data["deaths"]?> Tode (<?php echo $this->pos_neg_draw_helper($data["delta"]["deaths"])?>)</div>
			<div><?php echo $data["recovered"]?> Genesen (<?php echo $this->pos_neg_draw_helper($data["delta"]["recovered"],"green","red")?>)</div>
			
			<div>7T-Inzidenz: <?php echo $data["weekIncidence"]?> | R-Wert: <?php echo $data["r"]["value"]?> (<?php echo date("d.m.Y",strtotime($data["r"]["date"])); ?>)</div>
			
			<div class="meta">Stand: <?php echo date("d.m.Y",strtotime($data["meta"]["lastUpdate"])) ?> | Daten: <?php echo $data["meta"]["source"] ?> | API: <a target="_blank" rel="nofollow" href="https://github.com/marlon360/rki-covid-api">api.corona-zahlen.org</a></div>
		
		
		</div>

		<?php
		$out=ob_get_clean();
		
		return $out;
	}
}