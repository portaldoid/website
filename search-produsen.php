<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Portal_Donasi
 */
get_header();
?>

	<div id="primary" class="content-area">
        <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="row">
				<div class="col">
		    		<input type="text" class="field form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Produsen', 'twentyeleven' ); ?>" value="<?php echo $_GET['s']; ?>" />
				</div>
				<div class="col">
					<input type="text" class="field form-control" name="category_label" id="category_label" placeholder="<?php esc_attr_e( 'Daerah Produksi', 'twentyeleven' ); ?>" value="<?php echo $_GET['category_label']; ?>" />
					<input type="hidden" class="field form-control" name="category_name" id="category_name" />
				</div>
				<div class="col">
					<?php
					$production_types = get_terms( array(
					    'taxonomy' => 'tipe_produksi',
					    'hide_empty' => false
					) );

					if ( !empty($production_types) ) :
					    $output_production_types = '<select name="tipe_produksi" class="form-control">';
							$output_production_types.= '<option value="">Semua tipe produksi</option>';
						    foreach( $production_types as $production_type ) {
                                if ( $_GET['tipe_produksi'] == $production_type->slug ) {
                                    $production_type_selected = 'selected';
                                } else {
                                    $production_type_selected = '';
                                }
								$output_production_types.= '<option value="'. esc_attr( $production_type->slug ) .'" '. $production_type_selected .'>
									'. esc_html( $production_type->name ) .'</option>';
						    }
					    $output_production_types.='</select>';
					    echo $output_production_types;
					endif;
					?>
				</div>
				<div class="col p-l-0">
					<input type="hidden" name="post_type" value="produsen" />
	    			<input type="submit" class="btn btn-primary btn-block btn-search" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
				</div>
			</div>
		</form>
		<main id="main" class="site-main">
			<div class="row">
				<div class="col-lg-12">
					<?php
                    $_nama_produsen = $_GET['s'] != '' ? $_GET['s'] : '';
					$_tipe_produksi = $_GET['tipe_produksi'] != '' ? $_GET['tipe_produksi'] : '';

					$args = array(
					    'post_type' => 'produsen',
						'posts_per_page' => 10,
                        'orderby' => 'title',
 						'order' => 'ASC',
						'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
					);

					if( !empty( $_nama_produsen ) ) {
						$args['meta_query'] = array(
							array(
                                'key'     => 'nama_usaha',
                                'value'   => $_nama_produsen,
                                'compare' => 'LIKE',
                            ),
						);
					}

					if( !empty( $_GET['category_name'] ) ) {
						$args['category_name'] = $_GET['category_name'];
					}

					if( !empty( $_tipe_produksi ) ) {
						$args['tax_query'] = array(
						    array (
						        'taxonomy' => 'tipe_produksi',
						        'field' => 'slug',
						        'terms' => $_tipe_produksi,
						    )
						);
					}

					$query = new WP_Query( $args );

                    if( get_query_var('paged') ) {
						$paged_no = ( get_query_var('paged')*$query->query_vars['posts_per_page'] ) - 9;
					} else {
						$paged_no = 1;
					}

					if ( $query->have_posts() ) {
					?>
                    <div class="table-responsive-lg">
						<table class="table table-striped">
							<thead class="thead-dark">
						      <tr>
						        <th scope="col">#</th>
						        <th scope="col">Nama Usaha</th>
						        <th scope="col">Nama Pemilik</th>
								<th scope="col">Daerah Produsen</th>
						        <th scope="col">Produksi</th>
						        <th scope="col">Kontak</th>
						        <th scope="col">Alamat</th>
						        <th scope="col">Kapasitas</th>
                                <th scope="col">Harga</th>
						      </tr>
						    </thead>
						    <tbody>
								<?php
									while ( $query->have_posts() ) {
										$query->the_post();
								?>
									<tr>
                                        <td><?php echo $paged_no; ?>
                                        <td><?php echo get_post_meta(get_the_ID(), 'nama_usaha', true); ?></td>
										<td><?php echo get_the_title(); ?></td>
										<td><?php comma_separated_cat(get_the_ID(), 'category'); ?></td>
                                        <td><?php comma_separated_cat(get_the_ID(), 'tipe_produksi'); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'kontak', true); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'address', true); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'kapasitas', true); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'harga', true); ?></td>
									</tr>
								<?php
                                    $paged_no++;
									}
								wp_reset_postdata();
								?>
						</table>
					</div>
					<div class="row">
						<div class="col"></div>
						<div class="col-6">
							<div class="pagination">
							<?php
								$big = 999999999; // need an unlikely integer

								echo paginate_links( array(
									'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format' => '?paged=%#%',
									'prev_text'  => __(' Previous'),
									'next_text'  => __('Next '),
									'current' => max( 1, get_query_var('paged') ),
									'total' => $query->max_num_pages
								));
							} else {
							?>
							<div class="table-responsive-lg">
								<table class="table table-striped">
									<thead class="thead-dark">
								      <tr>
								        <!-- <th scope="col">#</th> -->
								        <th scope="col">Tidak ditemukan produsen</th>
								      </tr>
								    </thead>
								</table>
							</div>
						<?php } ?>
							</div>
						</div>
						<div class="col"></div>
					</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
