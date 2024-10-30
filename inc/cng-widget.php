<?php

class CNG_WIDGET extends CNG_ABSTRACT implements CNG_INTERFACE{
	function __construct(){
		parent::__construct();
	}

	function draw(){
		$data=$this->data;
		wp_enqueue_style('cng_widget_styles');
		if(key_exists("eigenes_css",$this->settings)){
			$inlineCss= $this->settings["eigenes_css"];
			wp_add_inline_style("cng_widget_styles",$inlineCss);
		}
		ob_start();?>
		<div class="cng-widget">
		<div><?php echo $this->getCoronaDays()." Tage" ?> (<?php echo $this->getCoronaTime() ?>)</div>
		<div><?php echo $data["cases"]?> Fälle (<?php echo $this->pos_neg_draw_helper($data["delta"]["cases"])?>)</div>
		<div><?php echo $data["deaths"]?> Tode (<?php echo $this->pos_neg_draw_helper($data["delta"]["deaths"])?>)</div>
		<div><?php echo $data["recovered"]?> Genesen (<?php echo $this->pos_neg_draw_helper($data["delta"]["recovered"],"green","red")?>)</div>
		<div><hr></div>
		<div>7T-Inzidenz: <?php echo $data["weekIncidence"]?></div>
		<div>R-Wert: <?php echo $data["r"]["value"]?> (<?php echo date("d.m.Y",strtotime($data["r"]["date"])); ?>)</div>
		<div><hr></div>
		<div class="meta">Stand: <?php echo date("d.m.Y",strtotime($data["meta"]["lastUpdate"])) ?></div>
		<div class="meta">Daten: <?php echo $data["meta"]["source"] ?></div>
		
		<div class="meta">API: <a target="_blank" rel="nofollow" href="https://github.com/marlon360/rki-covid-api">api.corona-zahlen.org</a></div>
		</div>

		<?php
		$out=ob_get_clean();
		return $out;
	}
}

add_action( 'widgets_init', function() {
            register_widget( 'CNG_WIDGET_CONTAINER' );
});

class CNG_WIDGET_CONTAINER extends WP_Widget{
 
    function __construct() {
		parent::__construct(
			"cng-widget",
			"Corona Zahlen in Deutschland",
			array( 'description' => __( 'Das Widget der Corona-Zahlen in Deutschland' ), ) // Args
		);
    }
	 public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
		
		extract( $args );
        $title = apply_filters( 'widget_title', "Corona in Deutschland" );
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        $cng= new CNG_WIDGET();
		echo $cng->draw();
        echo $after_widget;		
    }

}