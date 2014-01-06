<?php
/**
* Widgets factory : registered the different widgetized areas
*
* 
* @package      Customizr
* @subpackage   classes
* @since        3.0
* @author       Nicolas GUILLAUME <nicolas@themesandco.com>
* @copyright    Copyright (c) 2013, Nicolas GUILLAUME
* @link         http://themesandco.com/customizr
* @license      http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

class TC_widgets {
  
      //Access any method or var of the class with classname::$instance -> var or method():
      static $instance;

      function __construct () {
        self::$instance =& $this;
        add_action( 'widgets_init'                          , array( $this , 'tc_widgets_factory' ));
      }


      /**
      * Registers the widget areas
      * 
      * @package Customizr
      * @since Customizr 3.0 
      */
      function tc_widgets_factory() {
        //default Customizr filtered args
        $default                  = apply_filters( 'tc_default_widget_args' ,
                                  array(
                                    'name'                    => '',
                                    'id'                      => '',
                                    'description'             => '',
                                    'class'                   => '',
                                    'before_widget'           => '<aside id="%1$s" class="widget %2$s">',
                                    'after_widget'            => '</aside>',
                                    'before_title'            => '<h3 class="widget-title">',
                                    'after_title'             => '</h3>',
                                  )
        );

        //declares the arguments array
        $args                     = array();

        //fills in the $args array and registers sidebars
        foreach ( TC_init::$instance -> widgets as $id => $infos) {
            foreach ( $default as $key => $default_value ) {
              if ('id' == $key ) {
                $args[$key] = $id;
              }
              else if ( 'name' == $key || 'description' == $key) {
                $args[$key] = !isset($infos[$key]) ? $default_value : call_user_func( '__' , $infos[$key] , 'customizr' );
              }
              else {
                $args[$key] = !isset($infos[$key]) ? $default_value : $infos[$key];
              }
            }
          //registers sidebars
          register_sidebar( $args );
        }
      }

}//end of class

