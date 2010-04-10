<?php



class HkHook extends HkHook_HkTools{

	private $op;

	public function __construct(){
		$this->startup = true;
	
		parent::__construct();
		
		global $hkHook_Op;
		$this->op=$hkHook_Op;


		//$this->setFilters();
	}
	
	public function startup(){

		if($this->op->optionsDBValue['troubleshoot']['tshoot_it']
				&& current_user_can($this->op->optionsDBValue['cap'])){
	
			wp_enqueue_style('HkHook_css', $this->plugin_dir_url.'HkHook.css',null,null,'all');
			wp_enqueue_script('HkHook_js', $this->plugin_dir_url.'HkHook.js',null,null,true);

			add_action('wp_footer',array($this,'printHooksInfo'));
			add_action('admin_footer',array($this,'printHooksInfo'));
			
			
			
			
			if($this->debug){
				add_action('wp_footer',array($this,'demoWindow'));
				add_action('admin_footer',array($this,'demoWindow'));
			}
		
		}
	
	}




	
	public function buildWindow($id,$title,$content,$width=null,$top=null,$left=null){
	
		$coord='';
		if(!empty($top) || !empty($left) || !empty($width)){
			$coord = 'style="';
			if(!empty($top)) $coord .= 'top: '.$top.'px;';
			if(!empty($left)) $coord .= 'left: '.$left.'px;';
			if(!empty($width)) $coord .= 'width: '.$width.'px;';
			$coord .= '"';
		}
?>

<div id="<?php echo $id; ?>" class="DW_window" <?php echo $coord; ?>>

	<div class="titlebar">
		<h2><?php echo $title; ?></h2>
		<a title="Close" class="close">x</a>
		<a title="Hide" class="hide">^</a>
		<a title="Minimize" class="minimax">-</a>
	</div>
	
	<div class="content">
<?php echo $content; ?>
	</div>
	
	<div class="statusbar">statusbar .:</div>
</div>
<?php }

	public function printHooksInfo(){
	
		$content = '<p><a href="'.site_url().'/wp-admin/'.$this->op->optionspagePath.
			'" title="'.$this->op->optionspageName.' Options Page">'.
			$this->op->optionspageName." Options Page</a></p>\n<p>&nbsp;</p>";
	
		if(is_admin()){
			global $hook_suffix;
			$content .= '
			<p><strong>These are the hooks you can hook to for this admin page:</strong></p>
			<ul>
				<li>do_action("admin_enqueue_scripts", '.$hook_suffix.');</li>
				<li>do_action("admin_print_styles-'.$hook_suffix.'");</li>
				<li>do_action("admin_print_styles");</li>
				<li>do_action("admin_print_scripts-'.$hook_suffix.'");</li>
				<li>do_action("admin_print_scripts");</li>
				<li>do_action("admin_head");</li>
				<li>do_action("admin_head-'.$hook_suffix.'");</li>
				<li>do_action("admin_footer");</li>
				<li>do_action("admin_print_footer_scripts");</li>
				<li>do_action("admin_footer-'.$hook_suffix.'");</li>
			</ul>
			<p>&nbsp;</p>
			';
		}
		
		$content .= wp_view_type();
		
		$this->buildWindow("HkHook1","Hikari Hooks Troubleshooter",$content);
	
	
	
	
	
	
	
	}










	public function demoWindow(){
		echo "demo window";
		$this->buildWindow("demoWin","Demo Window",
'		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus venenatis fringilla purus. Suspendisse ultrices, leo vitae mollis eleifend, mi orci volutpat justo, in mollis erat dolor at dolor. Etiam volutpat diam. Morbi diam. Cras leo enim, imperdiet sit amet, facilisis a, ullamcorper in, nunc. Nunc elit quam, egestas sed, viverra eget, tempus nec, turpis. Morbi mauris dolor, adipiscing id, facilisis eget, dapibus ac, turpis.</p>
		<p>Quisque nec magna. Morbi tellus nisl, ullamcorper sed, ullamcorper in, adipiscing et, tellus. Maecenas at urna. In vehicula est sed purus. Quisque lobortis vestibulum nulla. Sed lacinia pellentesque massa. Nulla facilisi. Vestibulum semper. Nulla vitae lacus eu mauris tincidunt luctus. Ut porttitor nisi quis tortor. Vestibulum adipiscing, elit id scelerisque molestie, tortor lacus ullamcorper neque, ut tristique mi purus sit amet orci.</p>
		<p>Ut venenatis lacus ut diam. Nunc dignissim mattis risus. Nam sollicitudin nunc ut mauris commodo venenatis. Fusce augue tortor, consectetuer non, cursus nec, aliquam ac, magna. Praesent orci.</p>
		<p class="debug">DW_mouseX: 893<br>DW_mouseY: 337<br>DW_offsetX: 15<br>DW_offsetY: 71<br>window: win1</p>'
				,500,400,700);
	
	}



}



global $hkHook;
$hkHook = new HkHook();