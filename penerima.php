<?php
/*
Template Name: Penerima
*/
get_header();
?>

	<div id="primary" class="content-area">
		<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="row">
				<div class="col">
		    		<input type="text" class="field form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Nama Penerima', 'twentyeleven' ); ?>" />
				</div>
				<div class="col">
					<input type="text" class="field form-control" name="category_label" id="category_label" placeholder="<?php esc_attr_e( 'Daerah Penerima', 'twentyeleven' ); ?>" />
					<input type="hidden" class="field form-control" name="category_name" id="category_name" />
				</div>
				<div class="col">
		    		<input type="text" class="field form-control" name="keperluan" id="keperluan" placeholder="<?php esc_attr_e( 'Keperluan', 'twentyeleven' ); ?>" />
				</div>
				<div class="col p-l-0">
					<input type="hidden" name="post_type" value="penerima" />
	    			<input type="submit" class="btn btn-primary btn-block btn-search" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
				</div>
			</div>
		</form>
		<main id="main" class="site-main">
			<div class="row">
				<div class="col-lg-12">
					<?php
					$args = array(
					    'post_type' => 'penerima',
						'posts_per_page' => 10,
                        'orderby' => 'title',
 						'order' => 'ASC',
						'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
					);
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
						        <th scope="col">Nama Penerima</th>
								<th scope="col">Daerah Penerima</th>
						        <th scope="col">Keperluan</th>
						        <th scope="col">Tipe Donasi</th>
						        <th scope="col">Kontak</th>
						        <th scope="col">Konfirmasi</th>
						        <th scope="col">Sumber</th>
						      </tr>
						    </thead>
						    <tbody>
								<?php
									while ( $query->have_posts() ) {
										$query->the_post();
								?>
									<tr>
										<th scope="row"><?php echo $paged_no; ?></th>
										<td><?php echo get_the_title(); ?></td>
										<td><?php comma_separated_cat(get_the_ID(), 'category'); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'keperluan', true); ?></td>
                                        <td><?php comma_separated_cat(get_the_ID(), 'tipe_donasi'); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'kontak', true); ?></td>
                                        <td><?php echo get_post_meta(get_the_ID(), 'konfirmasi', true); ?></td>
                                        <td>
                                            <a href='<?php echo get_post_meta(get_the_ID(), 'sumber', true); ?>'><?php echo get_the_title(); ?></a>
                                        </td>
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
							}
							?>
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
