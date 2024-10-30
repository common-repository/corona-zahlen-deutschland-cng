<?php


add_action("wp_footer","cng_overlay");
function cng_overlay(){
			$cng= new CNG_OVERLAY();
			echo $cng->draw();
}

class CNG_OVERLAY extends CNG_ABSTRACT implements CNG_INTERFACE {
	
	
	function __construct(){
		parent::__construct();
	}

	function draw(){		
		if($this->settings==false){
			return;
		}
		if(key_exists("overlay_aktivieren",$this->settings)&&$this->settings["overlay_aktivieren"]=="no"){
			return;
		}
		wp_enqueue_script ( 'cng_script');
		wp_enqueue_style("cng_overlay_styles");
		if(key_exists("eigenes_css",$this->settings)){
			$inlineCss= $this->settings["eigenes_css"];
			wp_add_inline_style("cng_overlay_styles",$inlineCss);
		}
		
		$data=$this->data;
		ob_start();
		
		$hidden="";
		$classes=array();
		$classes[]="hidden";
		if($this->settings["overlay_ausrichten"]=="left"){
			$classes[]="left";
		}else{
			$classes[]="right";
		}
		?>
		<div class="cng_overlay <?php echo implode(" ",$classes); ?>" style="">
		
			<div><span class="switch" onclick="toggleCoronaNumbers();"></span></div>
			
			<h2 class="headline">Corona<span class="small"> in Deutschland</span></h2>
			<div style="text-align:center;color:#fff;font-size:1rem">

			</div>
			<div class="duration">
						<?php echo $this->getCoronaDays()." Tage" ?> (<?php echo $this->getCoronaTime() ?>)
				</div>
			<div class="content">
				
				<div class="sect">
				
				<div class="key">Fälle</div>
				<span class="data"><?php echo $data["cases"]?></span> (<?php echo $this->pos_neg_draw_helper($data["delta"]["cases"])?>)</div>
				
				<div class="sect">
				<div class="key">Tode</div>
				<span class="data"><?php echo $data["deaths"]?></span> (<?php echo $this->pos_neg_draw_helper($data["delta"]["deaths"])?>)</div>
				
				<div class="sect">
				<div class="key">Genesen</div>
				<span class="data"><?php echo $data["recovered"]?></span> (<?php echo $this->pos_neg_draw_helper($data["delta"]["recovered"],"green","red")?>)</div>
				
				<div class="sect">
				<div class="key">7T-Inzidenz</div>
				<span class="data"><?php echo $data["weekIncidence"]?></span></div>
				
				<div class="sect">
				<div class="key">R-Wert</div>
				<span class="data"><?php echo $data["r"]["value"]?></span> <span>(<?php echo date("d.m.Y",strtotime($data["r"]["date"])); ?>)</span></div>
			</div>
			<div class="meta">
				Stand: <?php echo date("d.m.Y",strtotime($data["meta"]["lastUpdate"])) ?> Daten: <?php echo $data["meta"]["source"] ?> API: <a target="_blank" rel="nofollow" href="https://github.com/marlon360/rki-covid-api">api.corona-zahlen.org</a>
			</div>
		</div>
		<?php
		$out=ob_get_clean();
		return $out;
	}
}
