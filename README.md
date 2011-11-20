# Huh?
The Menu library is used to create hierchical HTML structures ideal for menu systems. To keep it flexible, it does not
generate the CSS and/or Javascript code for you. You have the pleasure of doing that yourself.


# Why?
This library came out of a need to apply current and parent CSS styles to a menu system in a project I was working on.
But the way I had it built, it couldn't be done without some hackery. So I got to work making this.


# Installing
* Copy/move files into place
    * /application/config/menu.php
    * /application/libraries/Menu.php
* Done


# Configuration
Still working on this section. Come back later.


# Example
    // Load the library
    $this->load->library('menu');

    // Menu structure. This could be generated or static
    $menu = array(
        array(
            'uri' => '',
            'label' => 'Home'
        ),
        array(
            'uri' => 'services',
            'label' => 'Services',
            'children' => array(
                array(
                    'uri' => 'services/foo/',
                    'label' => 'Foo'
                ),
                array(
                    'uri' => 'services/bar',
                    'label' => 'Bar'
                )
            )
        ),
        array(
            'uri' => 'about',
            'label' => 'About Us'
            'children' => array(
                array(
                    'uri' => 'about/team/',
                    'label' => 'Team'
                ),
                array(
                    'uri' => 'about/jobs',
                    'label' => 'Work For Us'
                )
            )
        ),
        array(
            'uri' => 'contact',
            'label' => 'Contact'
        )
    );

    // Render the menu (URI based)
    echo $this->menu->set_menu($menu)
        ->generate();

    // Render the menu (URI based)
    echo $this->menu->generate($menu);

	// Render the menu (Menu based)
    echo $this->menu->set_ancestry('menu')
        ->set_current('about', 'uri')
        ->generate($menu);

# Methods
## set_current() method
    /*
     * Set currently active menu item. Only applied when 'ancestry' is set to 'menu'
     *
     * $value string to look for when applying current and ancestry status
     * $key type of element to look at (eg. 'label', 'uri')
     */

    function set_current($value, $key = 'uri')...
    // example
      echo $this->menu->set_current('Foo', 'label');

## set_menu() method
    /*
     * Set menu items
     *
     * $menu multidimensional array of menu items
     */

    function set_menu($menu = array())...
    // example
      $my_menu = array(
        array(
            'uri' => '',
            'label' => 'Home'
        ),
        array(
            'uri' => 'about',
            'label' => 'About Us'
            'children' => array(
                    array(
                        'uri' => 'about/team',
                        'label' => 'Our Team'
                    )
                )
      );
      echo $this->menu->set_menu($my_menu');

## set_ancestry() method
    /*
     * Set ancestry type
     *
     * $ancestry type of ancestry detection to use. Use 'path' or 'menu'
     */

    function set_ancestry($ancestry = 'path')...
    // example
      echo $this->menu->set_ancestry('menu');

## generate() method
    /*
     * Generate menu
     *
     * $menu items for the menu if not already defined
     * $config configuration values for the menu
     */

    function generate($items = NULL, $config = array())...
    // example
      $my_menu = array(
        array(
            'uri' => '',
            'label' => 'Home'
        ),
        array(
            'uri' => 'about',
            'label' => 'About Us'
            'children' => array(
                    array(
                        'uri' => 'about/team',
                        'label' => 'Our Team'
                    )
                )
      );
      echo $this->menu->generate($my_menu);

## render() method
    /*
     * Alias for generate(). See generate()
     */

    function render($items = NULL, $config = array())...
      echo $this->menu->render();


# TODO
* Turn it into a Spark!
* Flat array to multidimensional (for SQL results)
* Verify GET params work when generating ancestry. Optionaly look at GET params when checking for current, parent, ancestor
* Generate JSON result?


# License
DON'T BE A DICK PUBLIC LICENSE

Version 1, December 2009

Copyright (C) 2009 Philip Sturgeon <email@philsturgeon.co.uk>

Everyone is permitted to copy and distribute verbatim or modified copies of this license document, and changing it is allowed as long as the name is changed.

DON'T BE A DICK PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

1. Do whatever you like with the original work, just don't be a dick.

Being a dick includes - but is not limited to - the following instances:

1a. Outright copyright infringement - Don't just copy this and change the name.
1b. Selling the unmodified original with no work done what-so-ever, that's REALLY being a dick.
1c. Modifying the original work to contain hidden harmful content. That would make you a PROPER dick.

2. If you become rich through modifications, related works/services, or supporting the original work, share the love. Only a dick would make loads off this work and not buy the original works creator(s) a pint.

3. Code is provided with no warranty. Using somebody else's code and bitching when it goes wrong makes  you a DONKEY dick. Fix the problem yourself. A non-dick would submit the fix back.