<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Menu Class
 *
 * This class enables the creation of menu system
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		David Freerksen
 * @link		https://github.com/dfreerksen/ci-menu
 *
 * TODO: Develop 'add' method to add an item or items at the end or at a certain index. Nested adding?
 * TODO: Develop 'remove' method. Nested removing?
 * TODO: Add menu vs path ancestors
 */
class Menu {

	protected $CI;

	protected $_version = '1.0.0';

	protected $_config = array(
		'items' => array(),
		// wrapper
		'wrapper_element' => 'div',
		'wrapper_id' => '',
		'wrapper_class' => 'menu-wrapper',
		// menu wrapper
		'menu_element' => 'ul',
		'menu_id' => 'menu',
		'menu_class' => '',
		// item wrapper
		'item_element' => 'li',
		// inner item
		'item_link_before' => '',
		'item_link_after' => '',
		'item_label_before' => '',
		'item_label_after' => '',
		// children
		'child_node' => 'children',
		'submenu_class' => 'sub-menu',
		'has_children_class' => 'item-has-children',
		// index classes
		'level_class' => 'level-%1$d',
		'item_class' => 'menu-item menu-item-%1$d level-%2$d-item-%1$d',
		'item_first_class' => 'menu-item-first',
		'item_last_class' => 'menu-item-last',
		// external links
		'item_external_link_class' => 'external-link',
		// ancestry
		'ancestry' => 'path',   // 'menu' or 'path'
		'item_current_class' => 'menu-item-current',
		'item_current_parent_class' => 'menu-item-parent',
		'item_current_ancestor_class' => 'menu-item-ancestor',
		// depth
		'depth' => 0
	);

	protected $_current = '';

	/**
	 * Constructor
	 *
	 * @param   array   $config
	 */
	public function __construct($config = array())
	{
		$this->CI =& get_instance();

		if ( ! empty($config))
		{
			$this->initialize($config);
		}

		log_message('debug', 'Menu Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Set config values
	 *
	 * @param   array   $config
	 */
	public function initialize($config = array())
	{
		if (count($config) > 0)
		{
			foreach ($config as $key => $val)
			{
				//$key = preg_replace('/^menu_/i', '', $key);
				$this->__set($key, $val);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * get magic method. Returns NULL if not found
	 *
	 * @param   string  $name
	 * @return  mixed
	 */
	public function __get($name)
	{
		// Get the version
		if ($name === 'version')
		{
			return $this->_version;
		}

		// All other 'get' items
		return array_key_exists($name, $this->_config) ? $this->_config[$name] : NULL;
	}

	// ------------------------------------------------------------------------

	/**
	 * set magic method. Will only set the value for known keys
	 *
	 * @param   string  $name
	 * @param   mixed   $value
	 * @return  bool
	 */
	public function __set($name, $value)
	{
		if (array_key_exists($name, $this->_config))
		{
			$this->_config[$name] = $value;

			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate menu
	 *
	 * @param   array   $items
	 * @param   array   $config
	 * @return  string
	 */
	public function generate($items = NULL, $config = array())
	{
		$output = '';

		// Set the config values
		if ( ! empty($config))
		{
			$this->initialize($config);
		}

		// Add the items to the menu
		if (is_array($items))
		{
			$this->__set('items', $items);
		}

		// Wrapper open
		$attr = array(
			'id' => $this->__get('wrapper_id'),
			'class' => $this->__get('wrapper_class')
		);
		$output .= $this->_element_open($this->__get('wrapper_element'), $attr);

		//var_dump( $this->_array_search_recursive(TRUE, $this->__get('items') , 'current') );

		// Recursively generate items
		$output .= $this->_generate_items($this->__get('items'));

		// Wrapper close
		$output .= $this->_element_close($this->__get('wrapper_element'));

		// Done!
		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Search multi-dimensional array
	 *
	 * @param   string  $needle
	 * @param   array   $haystack
	 * @param   string  $needle_key
	 * @param   bool    $strict
	 * @param   array   $path
	 * @return  array|bool
	 */

	private function _array_search_recursive($needle, $haystack, $needle_key = NULL, $path = array())
	{
		if( ! is_array($haystack))
		{
			return FALSE;
		}

		foreach($haystack as $key => $value)
		{
			// Key is defined
			if ($needle_key)
			{
				if (is_scalar($value) AND $value == $needle AND $key == $needle_key)
				{
					$path[] = $key;

					return $path;
				}
				elseif (is_array($value) AND $subPath = $this->_array_search_recursive($needle, $value, $needle_key, $path))
				{
					$path = array_merge($path, array($key), $subPath);

					return $path;
				}
			}

			// Key is not defined
			else
			{
				if (is_array($value) AND $subPath = $this->_array_search_recursive($needle, $value, $needle_key, $path))
				{
					$path = array_merge($path, array($key), $subPath);

					return $path;
				}

				elseif ($value == $needle)
				{
					$path[] = $key;

					return $path;
				}
			}
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate menu items for level
	 *
	 * @param   array   $menu
	 * @param   int $level
	 * @return  string
	 */
	private function _generate_items($menu = array(), $level = 1)
	{
		$result = '';

		// If it' not already set, set the current page location
		if ( ! $this->_current)
		{
			$this->_current = $this->CI->uri->uri_string();
		}

		// If there are menu items, add the opening menu wrapper
		if (count($menu))
		{


			// The first level of items
			if ($level === 1)
			{
				$attr = array(
					'id' => $this->__get('menu_id'),
					'class' => array($this->__get('menu_class'))
				);
			}

			// Sub level menu (level 2+)
			else
			{
				$attr = array(
					'class' => array($this->__get('submenu_class'))
				);
			}

			// Add the level class
			array_push($attr['class'], sprintf($this->__get('level_class'), $level));

			// Now the actual opening menu element
			$result .= $this->_element_open($this->__get('menu_element'), $attr);
		}

		// Loop over the level
		foreach ($menu as $index => $item)
		{
			// Incremented index
			$level_up = $index + 1;

			// Does this item have a child menu?
			$has_children = array_key_exists($this->__get('child_node'), $item);

			// Have we hit the max depth level?
			$depth_hit = $level == $this->__get('depth');

			// Href for current item
			$href = (array_key_exists('uri', $item)) ? $item['uri'] : '';

			// Is it an external link?
			$is_external = $this->_is_external($href);

			// Open item attributes
			$attr = array(
				'class' => array()
			);

			// Add generic item class
			array_push($attr['class'], sprintf($this->__get('item_class'), $level_up, $level));

			// If this item has children and he haven't hit the depth limit, add a class
			// Useful for creating arrows to notify the user there are sub menu items
			if ($has_children AND ! $depth_hit)
			{
				array_push($attr['class'], $this->__get('has_children_class'));
			}

			// Add class for current page
			if ( ! $is_external AND $this->_is_current($href))
			{
				array_push($attr['class'], $this->__get('item_current_class'));
			}

			// Add class for immediate parent of current page
			if ( ! $is_external AND $this->_is_ancestor($href, TRUE))
			{
				array_push($attr['class'], $this->__get('item_current_parent_class'));
			}

			// Add class for ancestor (including parent) of current page
			if ( ! $is_external AND ! $this->_is_current($href) AND $this->_is_ancestor($href))
			{
				array_push($attr['class'], $this->__get('item_current_ancestor_class'));
			}

			// Add class for external links
			if ($is_external)
			{
				array_push($attr['class'], $this->__get('item_external_link_class'));
			}

			// Add 'first' item class
			if ($index === 0)
			{
				array_push($attr['class'], $this->__get('item_first_class'));
			}

			// Add 'last' item class
			if ($index === count($menu) - 1)
			{
				array_push($attr['class'], $this->__get('item_last_class'));
			}

			// Open item
			$result .= $this->_element_open($this->__get('item_element'), $attr);

			// Create the label
			$result .= $this->_create_label($item);

			// Create the children if we haven't hit the depth limit
			if ($has_children AND ! $depth_hit)
			{
				// Next level
				$next_level = $level + 1;

				// Add the child menu
				$result .= $this->_generate_items($item[$this->__get('child_node')], $next_level);
			}

			// Close item
			$result .= $this->_element_close($this->__get('item_element'));
		}

		// If there are menu items, add the closing menu wrapper
		if (count($menu))
		{
			$result .= $this->_element_close($this->__get('menu_element'));
		}

		// Menu built
		return $result;
	}

	// ------------------------------------------------------------------------

	/**
	 * Build open element string
	 *
	 * @param   string  $element
	 * @param   array   $attributes
	 * @param   bool    $newline
	 * @return  string
	 */
	private function _element_open($element = '', $attributes = array(), $newline = TRUE)
	{
		// Only run if an element was passed
		if ($element)
		{
			// Attribute array passed. Create string
			if (is_array($attributes))
			{
				$attributes = $this->_array_to_string($attributes);
			}

			$result = '<'.$element.$attributes.'>';

			if ($newline)
			{
				$result .= "\n";
			}

			return $result;
		}

		return '';
	}

	// ------------------------------------------------------------------------

	/**
	 * Build close element string
	 *
	 * @param   string  $element
	 * @param   bool    $newline
	 * @return  string
	 */
	private function _element_close($element = '', $newline = TRUE)
	{
		// Only run if an element was passed
		if ($element)
		{
			$result = '</'.$element.'>';

			if ($newline)
			{
				$result .= "\n";
			}

			return $result;
		}

		return '';
	}

	// ------------------------------------------------------------------------

	/**
	 * Build item label and link
	 *
	 * @param   array  $item
	 * @return  string
	 */
	private function _create_label($item = array())
	{
		$result = '';

		// Before the link tag
		$result .= $this->__get('item_link_before');

		// Open link tag
		$attr = array();

		// Href
		$href = array_key_exists('uri', $item) ? $item['uri'] : '';

		// If the href is not a URL, add the site_url
		if ( ! $this->_is_url($href))
		{
			$href = $this->CI->config->site_url($href);
		}

		$attr['href'] = $href;

		// Title
		if (array_key_exists('title', $item))
		{
			$attr['title'] = $item['title'];
		}
		else
		{
			$attr['title'] = (array_key_exists('label', $item)) ? $item['label'] : '';
		}

		// Before label
		$label = $this->__get('item_label_before');

		if (array_key_exists('label', $item))
		{
			$label .=  $item['label'];
		}

		// After label
		$label .= $this->__get('item_label_after');

		// So we have accounted for required values of href, title, and label
		unset($item['href']);
		unset($item['title']);
		unset($item['label']);

		// Let's not forgot about child items
		unset($item[$this->__get('child_node')]);

		// Everything else must be anchor attributes
		foreach ($item as $key => $value)
		{
			$attr[$key] = $value;
		}

		// Open link tag
		$result .= $this->_element_open('a', $attr, FALSE);

		// Link tag
		$result .= $label;

		// Close link tag
		$result .= $this->_element_close('a');

		// After the link tag
		$result .= $this->__get('item_link_after');

		return $result;
	}

	// ------------------------------------------------------------------------

	/**
	 * Build attribute string from array
	 *
	 * @param   array   $attributes
	 * @return  string
	 */
	private function _array_to_string($attributes = array())
	{
		$attr = '';

		// If it is already a sring, nothing more to do
		if (is_string($attributes))
		{
			return ($attributes != '') ? ' '.$attributes : '';
		}

		// Loop over each item
		foreach ($attributes as $key => $value)
		{
			// If there is no value, no need in adding the attribute
			if ($value)
			{
				// If the value is an array, implode it into a string separated by a space
				if (is_array($value))
				{
					$value = implode(' ', array_filter($value));
				}

				$attr .= ' '.$key.'="'.$value.'"';
			}
		}

		return $attr;
	}

	// ------------------------------------------------------------------------

	/**
	 * Test if viewing current menu item in browser
	 *
	 * @param   string  $href
	 * @return  bool
	 */
	private function _is_current($href = '')
	{
		$item_path = $href;

		// If it is a full URL, get the path info
		if ($this->_is_url($href))
		{
			$item_path = parse_url($href, PHP_URL_PATH);
		}

		// Get the path of the current page
		$current_path = parse_url($this->_current, PHP_URL_PATH);

		// If the item path and current page path are the same
		if ($this->_clean_link($item_path) === $this->_clean_link($current_path))
		{
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Test if viewing ancestor of current menu item in browser
	 *
	 * @param   string  $href
	 * @return  bool
	 */
	private function _is_ancestor($href = '', $parent = FALSE)
	{
		$item_path = $href;

		// If it is a full URL, get the path info
		if ($this->_is_url($href))
		{
			$item_path = parse_url($href, PHP_URL_PATH);
		}

		// Explode to array
		$item_path = explode('/', $this->_clean_link($item_path));

		// Get the path of the current page
		$ancestor_path = parse_url($this->_current, PHP_URL_PATH);

		// Explode current page to array
		$ancestor_path = explode('/', $this->_clean_link($ancestor_path));

		// Unset the last item in the current page
		if (count($ancestor_path))
		{
			// Get the immediate parent path
			if ($parent)
			{
				$ancestor_path = array_slice($ancestor_path, 0, -1);
			}

			// Get the root path
			else
			{
				$ancestor_path = array_slice($ancestor_path, 0, 1);
			}
		}

		// If the item path and current page path are the same
		if ($item_path === $ancestor_path)
		{
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Test if link is external from current domain
	 * 
	 * @param   string  $href
	 * @return  bool
	 */
	private function _is_external($href = '')
	{
		$regex = '/^'.preg_quote(rtrim($this->CI->config->base_url(), '/'), '/').'/i';

		if ($this->_is_url($href) AND ! preg_match($regex, $href))
		{
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Clean parses URI path
	 * 
	 * @param   string  $href
	 * @return  string
	 */
	private function _clean_link($href = '')
	{
		return strtolower(trim($href, '/'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Test if valid link
	 * 
	 * @param   string  $str
	 * @return  bool
	 */
	private function _is_url($str = '')
	{
		return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str)) ? FALSE : TRUE;
	}

}

// END Menu class

/* End of file Menu.php */
/* Location: ./application/libraries/Menu.php */