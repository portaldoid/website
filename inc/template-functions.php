<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Portal_Donasi
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function portal_donasi_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'portal_donasi_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function portal_donasi_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'portal_donasi_pingback_header' );

add_action( 'admin_menu', 'remove_menu_pages' );
function remove_menu_pages() {
    remove_menu_page('edit-comments.php');
	remove_menu_page('upload.php');
	// remove_menu_page('themes.php');
	// remove_menu_page('plugins.php');
	// remove_menu_page('tools.php');
	// remove_menu_page('options-general.php');
}

function comma_separated_cat($post_id, $taxonomy) {
    $terms = get_the_terms($post_id, $taxonomy );
    $terms_meta = [];
    if ( ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $terms_meta[] = $term->name;
        }
    }

    if ( ! empty( $terms_meta ) ) {
        $terms_string = implode( ', ', $terms_meta );
    } else {
        $terms_string = '';
    }

    echo $terms_string;
}

function template_chooser($template) {
	global $wp_query;

	if( isset( $_GET['post_type'] ) ) {
		$post_type = $_GET['post_type'];
	} else {
		$post_type = 'any';
	}

	if( $wp_query->is_search && $post_type == 'penerima' )   {
		return locate_template('search-penerima.php');  //  redirect to archive-search.php
	} elseif ( $wp_query->is_search && $post_type == 'produsen' ) {
		return locate_template('search-produsen.php');
	}
	return $template;
}
add_filter( 'template_include', 'template_chooser' );

add_action( 'wp_loaded', 'import_produsen' );
function import_produsen() {
	if( isset(  $_GET['import'] ) ) {
		if( $_GET['import'] == 'produsen' ) {
			if (($handle = fopen(PDCOVID_THEME_DIR . '/assets/Donasi Covid - produsen.csv', "r")) !== FALSE) {
				$row = 1;
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$daerah = array_map('intval', explode(',', $data[4]));
					$produksi = array_map('intval', explode(',', $data[15]));

					$post_arr = array(
                        'post_title'   => esc_attr($data[1]),
                        'post_status'  => 'publish',
                        'post_author'  => 1,
                        'post_type'    => 'produsen',
                        'post_category' => $daerah,
						'tax_input'    => array(
                            "tipe_produksi" => $produksi,
                        ),
                        'meta_input'   => array(
                            'nama_usaha' => $data[2],
                            'address'   => $data[3],
                            'kontak'   => $data[7],
                            'kapasitas'   => $data[11],
                            'harga'   => $data[12]
                        ),
                    );

                    $post_id = wp_insert_post( $post_arr );

                    if( $post_id ) {
                        echo $row . 'berhasil.<br />\n';
                    } else {
                        echo $row . 'gagal masuk.<br />\n';
                    }
                    $row++;
				}
				fclose($handle);
            }
            exit();
		}
	}
}

add_action( 'wp_loaded', 'import_penerima' );
function import_penerima() {
    if( isset( $_GET['import'] ) ) {

        if( $_GET['import'] == 'penerima' ) {
            $cats = [];
            $taxonomies = get_terms( array(
                'taxonomy' => 'category',
                'hide_empty' => false
            ) );
            foreach( $taxonomies as $category ) {
                $cats[$category->name] = $category->term_id;
            }

            $row = 1;
            if (($handle = fopen(PDCOVID_THEME_DIR . '/assets/Donasi Covid - penerima.csv', "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // daerah from excel
                    $daerah = [];
                    if( $data[3] != "" ) {
                        $daerah[] = $cats[$data[3]];
                    }
                    $daerah[] = $cats[$data[4]];
					$tipe_int = array_map('intval', explode(',', $data[9]));

					$post_arr = array(
                        'post_title'   => esc_attr($data[1]),
                        'post_status'  => 'publish',
                        'post_author'  => 1,
                        'post_type'    => 'penerima',
                        'post_category' => $daerah,
                        'tax_input'    => array(
                            "tipe_donasi" => $tipe_int
                        ),
                        'meta_input'   => array(
                            'keperluan' => $data[2],
                            'rekening'   => $data[5],
                            'kontak'   => $data[7],
                            'konfirmasi'   => $data[6],
                            'sumber'   => $data[8]
                        ),
                    );

                    $post_id = wp_insert_post( $post_arr );

                    if( $post_id ) {
                        echo $row . 'berhasil.<br />\n';
                    } else {
                        echo $row . 'gagal masuk.<br />\n';
                    }
                    $row++;
                }
				exit();
            }
        }
    }
}

add_action( 'wp_loaded', 'import_penyalur' );
function import_penyalur() {
    if( isset( $_GET['import'] ) ) {
        $cats = [];
        $taxonomies = get_terms( array(
            'taxonomy' => 'category',
            'hide_empty' => false
        ) );
        foreach( $taxonomies as $category ) {
            $cats[$category->name] = $category->term_id;
        }

        if( $_GET['import'] == 'penyalur' ) {
            $row = 1;
            if (($handle = fopen(PDCOVID_THEME_DIR . '/assets/Donasi Covid - penyalur.csv', "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // daerah from excel
                    $daerah = [];

                    $num = count($data);
                    if( $data[5] != "" ) {
                        $exp_d5 = explode(",",$data[5]);
                        foreach( $exp_d5 as $exp_key => $expd5s ) {
                            $daerah[] = $cats[ltrim($expd5s)];
                        }
                    }
                    $tipe_int = array_map('intval', explode(',', $data[3]));
                    $sasaran_int = array_map('intval', explode(',', $data[4]));

                    $post_arr = array(
                        'post_title'   => esc_attr($data[1]),
                        'post_status'  => 'publish',
                        'post_author'  => 1,
                        'post_type'    => 'post',
                        'post_category' => $daerah,
                        'tax_input'    => array(
                            "target" => $sasaran_int,
                            "tipe_donasi" => $tipe_int
                        ),
                        'meta_input'   => array(
                            'tipe_lembaga' => $data[2],
                            'rekening'   => $data[6],
                            'konfirmasi'   => $data[7],
                            'kontak'   => $data[8],
                            'sumber'   => $data[9],
                            'batas_akhir'   => $data[10],
                            'keperluan'   => $data[13]
                        ),
                    );

                    $post_id = wp_insert_post( $post_arr );

                    if( $post_id ) {
                        echo $row . 'berhasil.<br />\n';
                    } else {
                        echo $row . 'gagal masuk.<br />\n';
                    }
                    $row++;
                }
                fclose($handle);
            }
            exit();
        }
    }
}
