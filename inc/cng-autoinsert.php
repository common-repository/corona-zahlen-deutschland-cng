<?php
class CNG_AUTOINSERT extends CNG_ABSTRACT implements CNG_INTERFACE{
	
	function __construct(){
		parent::__construct();
	}

	function autoinsert_callback($content){
		$inPost=0;
		if(isset($this->settings["nach_dem_x_absatz_in_den_beitrag_einbinden"])){
			$inPost=$this->settings["nach_dem_x_absatz_in_den_beitrag_einbinden"];
		}
		$beforePost="";
		if(isset($this->settings["am_beitragsanfang_einbinden"])){
			$beforePost=$this->settings["am_beitragsanfang_einbinden"];
		}
		$afterPost="";
		if(isset($this->settings["am_beitragsende_einbinden"])){
			$afterPost=$this->settings["am_beitragsende_einbinden"];
		}
		if($inPost>0&&is_single()){
			$contentArgs=$this->splitn($content,"</p>",$inPost);
			$content=$contentArgs[0].$this->draw().$contentArgs[1];
		}
		
		if($beforePost=="on"&&is_single()){
			$content= $this->draw().$content;
		}
		
		if($afterPost=="on"&&is_single()){
			$content= $content.$this->draw();
		}
		
		$inPage=0;
		if(isset($this->settings["nach_dem_x_absatz_in_die_seiten_einbinden"])){
			$inPage=(int) $this->settings["nach_dem_x_absatz_in_die_seiten_einbinden"];
		}
		$beforePage="";
		if(isset($this->settings["am_seitenanfang_einbinden"])){
			$beforePage=$this->settings["am_seitenanfang_einbinden"];
		}
		$afterPage="";
		if(isset($this->settings["am_seitenende_einbinden"])){
			$afterPage=$this->settings["am_seitenende_einbinden"];
		}
		if($inPage>0&&is_page()){
			$contentArgs=$this->splitn($content,"</p>",$inPage);
			$content=$contentArgs[0].$this->draw().$contentArgs[1];
		}
		
		if($beforePage=="on"&&is_page()){
			$content= $this->draw().$content;
		}
		if($afterPage=="on"&&is_page()){
			$content= $content.$this->draw();
		}
		
		return $content;
	}
	
	function draw(){
		$cng= new CNG_SHORTCODE();
		return $cng->draw();
	}	

	
	private function splitn($string, $needle, $offset){
		$args=explode($needle,$string);
		$firstPart=array();
		$secondPart=array();
		$i=0;
		foreach($args as $value){
			$value=$value.$needle;
			if($i<$offset){
				$firstPart[]=$value;
			}else{
				$secondPart[]=$value;
			}
			$i++;
		}
		$out=array();
		$out[0]=implode("",$firstPart);
		$out[1]=implode("",$secondPart);
		return $out;
	}
}

$cng_autoinsert=new CNG_AUTOINSERT();
add_filter( 'the_content', array($cng_autoinsert,"autoinsert_callback"),99);