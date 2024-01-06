<?php
/**
 * Plugin Name: MFF Box
 * Plugin URI: https://mffwebagency.com.br/
 * Description: Gerenciamento de Torneios de Box
 * Version: 1.0.0
 * Author: Bruno Alves
 * Author URI: https://github.com/Cyber-Root0
 * Text Domain: mffbox
 * Domain Path: /i18n/languages/
 * Requires PHP: 7.4
 *
 * @package MffBox
 */
if ( ! defined("ABSPATH") ) exit;
class MffBox_init_Hook
{  
    protected static $instance = null;
    private function __construct(){
        $this->__loadDependencies();
        $this->init();
    } 
    public function init(){
        add_action( 'wp_enqueue_scripts', array($this, 'add_js_styles'), 999 ); 
       new MFFBox\registers\Shortcode();
    }       
    /**
     * add_js_styles
     *
     * @return void
     */
    public function add_js_styles(){
        wp_enqueue_script( 'mffbox-js-tab',"https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js", array ( 'jquery' ), 1.1, true);
        wp_enqueue_style('mffbox-css-tab', "https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css");
        wp_enqueue_script("mffweb-js-grid", "https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js");
        wp_enqueue_style('mffbox-css-grid', "https://unpkg.com/gridjs/dist/theme/mermaid.min.css");
    }
    /**
     * Singleton instance
     *
     * @return void
     */
    public static function instance(){
        if (is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }    
    /**
     * Load Class dependency
     *
     * @return void
     */
    private function __loadDependencies(){
        require_once __DIR__ ."/vendor/autoload.php";
    }
}
add_action('plugins_loaded', array('MffBox_init_Hook', 'instance' ) );
