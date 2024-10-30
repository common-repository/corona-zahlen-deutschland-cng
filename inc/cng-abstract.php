<?php
abstract class CNG_ABSTRACT{
	private $optionKey="coronaNumbersGermany";
	protected $data;
	protected $settings=array();
	
	function __construct(){
		$this->data=$this->getData();
		$this->loadSettings();
	}

	private function loadSettings(){
		$classname=get_class($this);
		if("CNG_SHORTCODE "==$classname){
			$this->settings=get_option( 'cng-shortcode', array() );
		}elseif("CNG_OVERLAY"==$classname){
			$this->settings=get_option( 'cng-overlay', array() );
		}elseif("CNG_AUTOINSERT"==$classname){
			$this->settings=get_option( 'cng-autoinsert', array() );
		}elseif("CNG_WIDGET"==$classname){
			$this->settings=get_option( 'cng-widget', array() );
		}
	}
	
	private function getData(){
		$refreshCache=false;
		$data=get_option($this->optionKey);
		if($data!=false){
			if(key_exists("meta",$data)&&key_exists("lastFetch",$data["meta"])){
				$lastUpdate=$data["meta"]["lastFetch"];
				if($this->isSameDate(new DateTime($lastUpdate),new DateTime('NOW'))==false){
					$refreshCache=true;
				}
			}else{
				$refreshCache=true;
			}			
		}else{
			$refreshCache=true;
		}
		
		if($refreshCache){
			$data= $this->fetchApi();
		}else{
		}
		return $data;
	}
	
	protected function isSameDate(DateTime $dateTimeOne,DateTime $dateTimeTwo){
		$dateTimeStringOne= $dateTimeOne->format('Y-m-d\TH:i:s.uZ');
		$dateTimeStringTwo= $dateTimeTwo->format('Y-m-d\TH:i:s.uZ');
		
		$dateTimeParsedOne= date_parse($dateTimeStringOne);
		$dateTimeParsedTwo=date_parse($dateTimeStringTwo);
		
		if($dateTimeParsedOne["year"]==$dateTimeParsedTwo["year"]&&$dateTimeParsedOne["month"]==$dateTimeParsedTwo["month"]&&$dateTimeParsedOne["day"]==$dateTimeParsedTwo["day"]){
			return true;
		}
		return false;		
	}
	
	protected function fetchApi(){
		$nowDate=new DateTime('NOW');
		$nowDateString=$nowDate->format('Y-m-d\TH:i:s.uZ');
		
		$apiData =wp_remote_retrieve_body(wp_remote_get( 'https://api.corona-zahlen.org/germany' ));
		
		$json=json_decode($apiData,true);
		$json["meta"]["lastFetch"]=$nowDateString;
		$option=get_option($this->optionKey);
		if($option==false){
			add_option($this->optionKey,$json);
		}else{
		update_option($this->optionKey,$json);
		}
		return $json;
	}
	
	public function getOptionKey(){
		return $this->optionKey;
	}
	
	public function pos_neg_draw_helper($number,$posColor=null,$negColor=null){
		if($posColor==null){
			$posColor="red";
		}
		if($negColor==null){
			$negColor="green";
		}
		
		$color=$posColor;
		if($number<0){
			$color=$negColor;
			$number="-".$number;
		}else{
			$number="+".$number;
		}
		return "<span style='color:$color'>$number</span>";
	}
	
	public function getCoronaLength(){
		$now=new DateTime('00:00');
		$pandemicStart=date_create_from_format("d.m.Y H:i","11.03.2020 00:00");
		$diff=date_diff($now,$pandemicStart);
		
		return $diff;
	}
	
	public function getCoronaDays(){
		$diff=$this->getCoronaLength();
		return $diff->days;
	}
	
	public function getCoronaTime(){
		$diff=$this->getCoronaLength();
		$timeArgs=array();
		
		if($diff->y>0){
			$word="Jahr";
			if($diff->y>1){
				$word="Jahre";
			}
			$timeArgs[]="$diff->y $word";
		}
		if($diff->m>0){
			$word="Monat";
			if($diff->m>1){
				$word="Monate";
			}
			$timeArgs[]="$diff->m $word";
		}
		if($diff->d>0){
			$word="Tag";
			if($diff->d>1){
				$word="Tage";
			}
			$timeArgs[]="$diff->d $word";
		}
		
		return implode(", ",$timeArgs);
	}
}