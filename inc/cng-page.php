<?php
if ( !class_exists( 'cng_RationalOptionPages' ) ) {
	require_once('rationalOptionPages/RationalOptionPages.php');
}

$overlayOptions = get_option( 'cng-overlay', array() );
$overlayCss="";
if(isset($overlayOptions["eigenes_css"]))
	$overlayCss=$overlayOptions["eigenes_css"];
$widgetOptions = get_option( 'cng-widget', array() );
$widgetCss="";
if(isset($widgetOptions["eigenes_css"]))
	$widgetCss=$widgetOptions["eigenes_css"];
$shortcodeOptions = get_option( 'cng-shortcode', array() );
$shortcodeCss="";
if(isset($shortcodeOptions["eigenes_css"]))
	$shortcodeCss=$shortcodeOptions["eigenes_css"];

$pages = array(
	'cng-settings'	=> array(
		'page_title'	=> __( 'CNG Einstellungen', 'cng_domain' ),
		'sections' => array(
					'section-desc'=>array(
						'title'=>__('Was macht das Plugin?','cng_domain'),
						'text'=>'<p>Das Plugin aggregiert die aktuellen Corona-Zahlen für Deutschland und bindet diese schlank und ressourcensparend in deine Website ein. Als Website-Beitreiber kannst du dabei auswählen, ob die Daten als Overlay, oder Widget in dein Webdesign integriert werden, automatisch in Beiträge und Seiten oder via Shortcode nur in ausgewählte Inhalte. </p>',
					),
					'section-credit'=>array(
						'title'=>__('Credits','cng_domain'),
						'text'=>'<p>Dieses Plugin basiert auf den offen zugänglichen Leistungen großartiger Menschen, die im Folgenden genannt werden:</p><ul>
						<li><a href="https://www.rki.de/DE/Home/homepage_node.html" target="_blank">Robert Koch Institut</a> (Datenerhebung)</li>
						<li><a href="https://marlon-lueckert.de/" target="_blank">Marlon Lückert</a> (elegante <a href="https://api.corona-zahlen.org/docs/" target="_blank">Corona-API</a> für Deutschland)</li>
						<li><a href="https://jeremyhixon.com/" target="_blank">Jeremy Hixon</a> (Verantwortlich für sexy <a href="https://github.com/jeremyHixon/RationalOptionPages" target="_blank">Settingpage-Generatoren</a>)</li>
						</ul>',
					),
				),
		
		
		'subpages' =>array(
			'cng-overlay' =>array(
				'parent_slug'=>'cng-overlay',
				'page_title'=>__('Overlay','cng_domain'),
				'sections' => array(
					'section-desc'=>array(
						'title'=>__('Was macht das Overlay?','cng_domain'),
						'text'=>'<p>Das Overlay wird am Bildschirmrand über die Inhalte der Website gelegt und präsentiert die aktuellen Corona-Zahlen. Es kann ganz einfach vom Nutzer minimiert werden.</p>',
					),
					'section-settings'=>array(
						'title'=>__('Einstellungen','cng_domain'),
						'fields'=>array(
							'radio-enable'			=> array(
								'title'			=> __( 'Overlay aktivieren', 'cng_domain' ),
								'type'			=> 'radio',
								'value'			=> $overlayOptions["overlay_aktivieren"]||"no",
								'choices'		=> array(
									'yes'	=> __( 'aktiviert', 'cng_domain' ),
									'no'	=> __( 'deaktiviert', 'cng_domain' ),
								),
							),
							'radio-align'			=> array(
								'title'			=> __( 'Overlay ausrichten', 'cng_domain' ),
								'type'			=> 'radio',
								'value'			=> $overlayOptions["overlay_ausrichten"]||"right",
								'choices'		=> array(
									'left'	=> __( 'Linker Bildschirmrand', 'cng_domain' ),
									'right'	=> __( 'Rechter Bildschirmrand', 'cng_domain' ),
								),
							),
							'textarea'		=> array(
								'title'			=> __( 'Eigenes CSS', 'cng_domain' ),
								'type'			=> 'textarea',
								'value'			=> $overlayCss,
							),
					
						)						
					)
				),
			
			),
			'cng-widget' =>array(
				'parent_slug'=>'cng-widget',
				'page_title'=>__('Widget','cng_domain'),
				'sections' => array(
					'section-desc'=>array(
						'title'=>__('Was macht das Widget?','cng_domain'),
						'text'=>'<p>Das Widget kann im Menüpunk Design > Widget in das Theme der Website eingebunden werden. Es gliedert sich in Seitenleisten und Fußzeilen ein und präsentiert dort die aktuellen Coronazahlen in Deutschland.</p>',
					),
					'section-settings'=>array(
						'title'=>__('Einstellungen','cng_domain'),
						'fields'=>array(
							'textarea'		=> array(
								'title'			=> __( 'Eigenes CSS', 'cng_domain' ),
								'type'			=> 'textarea',
								'value'			=> $widgetCss,
							),
					
						)						
					)
				),
			
			),
			'cng-shortcode' =>array(
				'parent_slug'=>'cng-shortcode',
				'page_title'=>__('Shortcode','cng_domain'),
				'sections' => array(
					'section-desc'=>array(
						'title'=>__('Was macht der Shortcode?','cng_domain'),
						'text'=>'<p>Der Shortcode kann über den code <input value="[cng]" onclick="select()" readonly style="border:0px;width:36px;"> an jeder beliebigen Stelle des Wordpress-Inhalts eingefügt werden und präsentiert dort die aktuellen Coronazahlen in Deutschland</p>',
					),
					'section-settings'=>array(
						'title'=>__('Einstellungen','cng_domain'),
						'fields'=>array(
							'textarea'		=> array(
								'title'			=> __( 'Eigenes CSS', 'cng_domain' ),
								'type'			=> 'textarea',
								'value'			=> $shortcodeCss,
							),
					
						)						
					)
				),
			
			),
			'cng-autoinsert' =>array(
				'parent_slug'=>'cng-autoinsert',
				'page_title'=>__('Auto-Insert','cng_domain'),
				'sections' => array(
						'section-desc'=>array(
							'title'=>__('Was macht der Auto-Insert?','cng_domain'),
							'text'=>'<p>Auto-Insert fügt den Shortcode des Plugins automatisch an bestimmten stellen auf der Website ein, ohne dass weiteres Zutun notwendig ist, und präsentiert dort die aktuellen Coronazahlen in Deutschland</p>',
						),
						'section-settings-posts'=>array(
							'title'=>__('Einstellungen für Beiträge','cng_domain'),
							'fields'=>array(
								'checkbox-davor'		=> array(
									'title'			=> __( 'Am Beitragsanfang einbinden', 'cng_domain' ),
									'type'			=> 'checkbox',
									'text'			=> __( '' ),
								),
								'checkbox-danach'		=> array(
									'title'			=> __( 'Am Beitragsende einbinden', 'cng_domain' ),
									'type'			=> 'checkbox',
									'text'			=> __( '' ),
								),
								'default-pos'		=> array(
									'title'			=> __( 'Nach dem x. Absatz in den Beitrag einbinden', 'cng_domain' ),
									'type'			=> 'number',
									'text'			=> "",
								),
							)						
						),
						'section-settings-pages'=>array(
							'title'=>__('Einstellungen für Seiten','cng_domain'),
							'fields'=>array(
								'checkbox-davor'		=> array(
									'title'			=> __( 'Am Seitenanfang einbinden', 'cng_domain' ),
									'type'			=> 'checkbox',
									'text'			=> __( '' ),
								),
								'checkbox-danach'		=> array(
									'title'			=> __( 'Am Seitenende einbinden', 'cng_domain' ),
									'type'			=> 'checkbox',
									'text'			=> __( '' ),
								),
								'default-pos'		=> array(
									'title'			=> __( 'Nach dem x. Absatz in die Seiten einbinden', 'cng_domain' ),
									'type'			=> 'number',
									'text'			=> "",
								),
							)						
						)
						
					),
			),
		)
	),
	
);
$option_page = new cng_RationalOptionPages( $pages );