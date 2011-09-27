<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// Load the library
		$this->load->library('menu');

		// Config for menu
		$config = array();

		// Menu structure. This could be generated or static
		$menu = array(
			array(
				'uri' => '',
				'label' => 'Home'
			),
			array(
				'uri' => 'appliances',
				'label' => 'Appliances',
				'children' => array(
					array(
						'uri' => 'appliances/kitchen/',
						'label' => 'Kitchen',
						'children' => array(
							array(
								'uri' => 'http://www.google.com',
								'label' => 'Laundry'
							),
							array(
								'uri' => 'appliances/kitchen/laundry2',
								'label' => 'Laundry 2'
							),
							array(
								'current' => TRUE,
								'uri' => 'appliances/kitchen/laundry3',
								'label' => 'Laundry 3'
							),
							array(
								'uri' => 'appliances/kitchen/laundry4',
								'label' => 'Laundry 4',
								'class' => 'zzz'
							)
						)
					),
					array(
						'uri' => 'appliances/laundry',
						'label' => 'Laundry'
					),
					array(
						'uri' => 'appliances/outdoor',
						'label' => 'Outdoor'
					),
				)
			),
			array(
				'uri' => 'about',
				'label' => 'About'
			),
			array(
				'uri' => 'contact',
				'label' => 'Contact'
			)
		);

		// Add the menu to the vaie variables
		$data = array(
			'menu' => $this->menu->generate($menu, $config)
		);

		$this->load->view('welcome_message', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */