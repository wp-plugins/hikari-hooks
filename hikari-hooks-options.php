<?php



global $hkHook_Op;
$hkHook_Op = new HkHook_Op();



class HkHook_Op extends HkHook_HkToolsOptions{


	public $optionsName = 'hkHook';
	protected $pluginfile = HkHook_pluginfile;
	protected $optionsDBVersion = 1;
	
	
	public $opStructure = array(
		"troubleshoot" => array( "name" => "Show hooks list",
				"desc" => 'Show the "Hikari Hooks Troubleshooter" window',
				"largeDesc" => "<p class=\"description\">This window lists all Hooks and Conditional Tags. Only users with correct capability will be able to see it.'</p>",
				"id" => "troubleshoot",
				"default" => array('tshoot_it' => true),
				"type" => "checkbox",
				"options" => array(
							array(
								'check_id'	=> 'tshoot_it',
								'desc'		=> 'show the window'
							)
				)
		),
		
		'cap' => array(	"name" => 'Viewing capability',
				"desc" => 'Choose the capability to be related to viewing the "Hikari Hooks Troubleshooter" window',
				"largeDesc" => "<p class=\"description\">Only users with the selected capability powers will be able to see it.</p>",
				"id" => 'cap',
				"default" => 'edit_plugins',
				"type" => "radio",
				"options" => array(
						'edit_plugins'	=> "edit_plugins (Administrators)",
						'unfiltered_html'	=> "unfiltered_html (Editors)",
						'edit_posts'	=> "edit_posts (Contributors)",
						'troubleshoot_hooks'	=> "troubleshoot_hooks (Custom)"
				)
		)
	
		);



	public function __construct(){
		parent::__construct();
		
		$role = get_role('administrator');
		if ($role !== NULL)
			$role->add_cap(troubleshoot_hooks);
			
		
		$this->uninstallArgs = array(
				'name' => $this->optionspageName,
				'plugin_basename' => HkHook_basename,
				'options' => array(
						array(
							'opType' => 'wp_options',
							'itemNames' => array($this->optionsDBName)
						)
					)
			);
		
		
		
	}






}
