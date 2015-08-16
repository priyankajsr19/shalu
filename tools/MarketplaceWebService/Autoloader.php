<?php

class MarketplaceWebService_Autoloader
{

    /**
     * Register the MarketplaceWebService autoloader
     *
     * The autoloader only acts for classnames that start with 'MarketplaceWebService'. It
     * will be appended to any other autoloaders already registered.
     *
     * Using this autoloader will disable any existing __autoload function. If
     * you want to use multiple autoloaders please use spl_autoload_register.
     *
     * @static
     * @return void
     */
    static public function register()
    {
        spl_autoload_register(array(new self, 'load'));
    }

    /**
     * Autoload a class
     *
     * This method is automatically called after registering this autoloader.
     * The autoloader only acts for classnames that start with 'MarketplaceWebService'.
     *
     * @static
     * @param string $class
     * @return void
     */
    static public function load($class)
    {
        if (substr($class, 0, 21) == 'MarketplaceWebService') {

            $class = str_replace(
                array('MarketplaceWebService', '_'),
                array('', '/'),
                $class
            );
            
            $file = dirname(__FILE__) . '/' . $class . '.php';

            require($file);
        }
	if( $class == 'RequestType') {
		$file = dirname(__FILE__).'/'.$class.'.php';
		require($file);
	}
    }

}
