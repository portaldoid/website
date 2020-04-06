<?php
/**
 * Nod
 *
 * @package pdcovid_theme
 */

namespace Pdcovid_Modules\Post;
defined( 'ABSPATH' ) || die( 'Can\'t access directly' );

/**
 * Class Setup
 */
class Ajax {
    /**
	 * Class constructor
	 */
	public function __construct() {
        add_action('wp_ajax_generate_daerah', [ $this, 'generate_daerah']);
        add_action('wp_ajax_nopriv_generate_daerah', [ $this, 'generate_daerah']);

        add_action('wp_ajax_generate_graph_data', [ $this, 'generate_graph_data']);
        add_action('wp_ajax_nopriv_generate_graph_data', [ $this, 'generate_graph_data']);
    }

    public function generate_daerah() {
        $regions = get_terms( array(
            'taxonomy' => 'category',
            'hide_empty' => false
        ));

        $arr_daerah = array();

        if ( !empty($regions) ) :
            foreach( $regions as $region ) {
                $arr_daerah[$region->slug] = $region->name;
            }
        endif;

        $result = json_encode($arr_daerah);
        echo $result;
        die();
    }

    public function generate_graph_data() {
        $result = json_encode('test');
        echo $result;
        die();
    }
}

new Ajax();
