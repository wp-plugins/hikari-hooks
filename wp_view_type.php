<?php
/* Debug WordPress Theme
   *******************************************************************
   1. Datei in das Theme kopieren
   2. Function in den body-Bereich der header.php des Themes einbinden
      </head>
      <body>
        <?php include (TEMPLATEPATH . '/wp_view_type.php'); ?>
   
   * Mehr Information im zugehoerigen Beitrag
     http://bueltge.de/wordpress-theme-debuggen/536/
     
   
   Frank Bueltge 2007, bueltge.de
   Version 0.2
   09.04.2008 22:23:55
   
   modified by Hikari from http://Hikari.ws
   for the plugin Hikari Hooks Troubleshooter
*/

global $view_is_not, $view_hooks;

$view_is_not = 'TRUE'; // FALSE oder 0 um die NICHT-Werte auszublenden, TRUE oder 1 fuer Ausgabe der NICHT-Werte
$view_hooks  = 'TRUE'; // FALSE oder 0 um die Hooks auszublenden, TRUE oder 1 fuer Ausgabe der Hooks

function view_conditional_tags() {
	global $view_is_not;
	
	$is = '';
	$is_not = '';

	if ( is_admin() ) $is .= "\t" . '<li><strong>is</strong> admin</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> admin</li>' . "\n";

	if ( is_archive() ) $is .= "\t" . '<li><strong>is</strong> archive</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> archive</li>' . "\n";

	if ( is_attachment() ) $is .= "\t" . '<li><strong>is</strong> attachment</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> attachment</li>' . "\n";

	if ( is_author() ) $is .= "\t" . '<li><strong>is</strong> author</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> author</li>' . "\n";

	if ( is_category() ) $is .= "\t" . '<li><strong>is</strong> category</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> category</li>' . "\n";

	if ( is_tag() ) $is .= "\t" . '<li><strong>is</strong> tag</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> tag</li>' . "\n";

	if ( is_comments_popup() ) $is .= "\t" . '<li><strong>is</strong> comments_popup</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> comments_popup</li>' . "\n";

	if ( is_date() ) $is .= "\t" . '<li><strong>is</strong> date</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> date</li>' . "\n";
	
	if ( is_day() ) $is .= "\t" . '<li><strong>is</strong> day</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> day</li>' . "\n";

	if ( is_feed() ) $is .= "\t" . '<li><strong>is</strong> feed</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> feed</li>' . "\n";
	
	if ( is_front_page() ) $is .= "\t" . '<li><strong>is</strong> front</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> front_page</li>' . "\n";
	
	if ( is_home() ) $is .= "\t" . '<li><strong>is</strong> home</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> home</li>' . "\n";
	
	if ( is_month() ) $is .= "\t" . '<li><strong>is</strong> month</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> month</li>' . "\n";

	if ( is_page() ) $is .= "\t" . '<li><strong>is</strong> page</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> page</li>' . "\n";

	if ( is_paged() ) $is .= "\t" . '<li><strong>is</strong> paged</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> paged</li>' . "\n";
	
	if ( is_plugin_page() ) $is .= "\t" . '<li><strong>is</strong> plugin_page</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> plugin_page</li>' . "\n";
	
	if ( is_preview() ) $is .= "\t" . '<li><strong>is</strong> preview</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> preview</li>' . "\n";

	if ( is_robots() ) $is .= "\t" . '<li><strong>is</strong> robots</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> robots</li>' . "\n";

	if ( is_search() ) $is .= "\t" . '<li><strong>is</strong> search</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> search</li>' . "\n";

	if ( is_single() ) $is .= "\t" . '<li><strong>is</strong> single</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> single</li>' . "\n";

	if ( is_singular() ) $is .= "\t" . '<li><strong>is</strong> singular</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> singular</li>' . "\n";

	if ( is_time() ) $is .= "\t" . '<li><strong>is</strong> time</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> time</li>' . "\n";

	if ( is_trackback() ) $is .= "\t" . '<li><strong>is</strong> trackback</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> trackback</li>' . "\n";

	if ( is_year() ) $is .= "\t" . '<li><strong>is</strong> year</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> year</li>' . "\n";

	if ( is_404() ) $is .= "\t" . '<li><strong>is</strong> 404</li>' . "\n";
	else $is_not .= '<li><em>isn\'t</em> 404</li>' . "\n";

	if ($view_is_not == ('TRUE' || 1)) {
		$is .= $is_not;
	}
	
	return $is;
}


function view_hooks() {
	global $wp_filter;
	
	$filter = '';
	ksort ($wp_filter);
	foreach ($wp_filter as $hook => $subhook) {
		$filter .= "\t" . '<li> Hook: <strong>' . $hook . '</strong>' . "\n";
		
		if(did_action($hook)) $filter .= " ran \n";
		//else  $filter .= " didn't run \n";

		$filter .= "\t\t" . '<ul>' . "\n";
		ksort ($subhook);
		foreach ($subhook as $prio => $subprio) {
			$filter .= "\t" . '<li><em>Priority:</em> ' . $prio . "\n<ul>";
			foreach ($subprio as $sub) {
				if(is_array($sub['function']))
					$subprioText = get_class($sub['function'][0]).' -> '.$sub['function'][1];
				else
					$subprioText = $sub['function'];

				
				$filter .= "\t" . '<li> Function: ' . $subprioText . '</li>' . "\n";
			}
			$filter .= '</ul></li>';
		}
		$filter .= "\t\t" . '</li></ul>' . "\n";
	}
	return $filter;
}


function wp_view_type() {
	global $view_hooks;

	$format .= '<h4 style="margin: 0 0 0 5px;">Conditional Tags</h4>';
	$format .= '<ul>' . "\n";
	$format .= view_conditional_tags();
	$format .= '</ul>' . "\n\n";
	
	if ($view_hooks == ('TRUE' || 1)) {
		$format .= '<h4 style="margin: 0 0 0 5px;">Actions &amp; Filters hooks</h4>';
		$format .= '<ol>' . "\n";
		$format .= view_hooks();
		$format .= '</ol>' . "\n";
	}

	$format .= "\n\n";	
	
	return $format;
}

//echo wp_view_type();
