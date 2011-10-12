<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// Load the library
		$this->load->library('menu');

		// Config for menu
		$config = array(
			//'ancestry' => 'menu' // Uncomment to do menu based paths instead of URL based
		);

		// Menu structure. This could be generated or static
		$menu = array(
			array(
				'uri' => '',
				'label' => 'Home'
			),
			array(
				'uri' => '#',
				'label' => 'Hash'
			),
			array(
				'uri' => '#top',
				'label' => 'Top'
			),
			array(
				'uri' => 'about#top',
				'label' => 'URI + Hash'
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
								'label' => 'Laundry 1'
							),
							array(
								'uri' => 'appliances/kitchen/laundry2',
								'label' => 'Laundry 2'
							),
							array(
								'uri' => 'appliances/kitchen/laundry3',
								'label' => 'Laundry 3'
							),
							array(
								'uri' => 'appliances/kitchen/laundry4',
								'label' => 'Laundry 4',
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

		// Add the menu to the view variables
		$data = array(
			'menu' => $this->menu
				//->set_current('Laundry 2', 'label') // Uncomment to set the 'Laundry 2' menu item as the current page (only pertains to menu based paths)
				->generate($menu, $config)
		);

		$this->load->view('welcome_message', $data);
	}

}
