<?php
/*
Template Name: Homepage
*/
get_header();
?>

	<div id="primary" class="content-area">
		<!-- <div class="row">
			<div class="col-sm-6 col-md-5 col-lg-6"></div>
			<div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
				<div id="force-directed"></div>
			</div>
		</div> -->
		<div id="force-directed"></div>
        <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="row">
				<div class="col-sm">
		    		<input type="text" class="field form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Nama Penyalur', 'twentyeleven' ); ?>" />
				</div>
				<div class="col-sm">
					<input type="text" class="field form-control" name="category_label" id="category_label" placeholder="<?php esc_attr_e( 'Daerah Penyaluran', 'twentyeleven' ); ?>" />
					<input type="hidden" class="field form-control" name="category_name" id="category_name" placeholder="<?php esc_attr_e( 'Search lokasi', 'twentyeleven' ); ?>" />
				</div>
				<div class="col-sm">
				<?php
					$targets = get_terms( array(
					    'taxonomy' => 'target',
					    'hide_empty' => false
					) );

					if ( !empty($targets) ) :
					    $output_target = '<select name="target" class="form-control">';
							$output_target.= '<option value="">Semua target</option>';
						    foreach( $targets as $target ) {
								$output_target.= '<option value="'. esc_attr( $target->slug ) .'">
									'. esc_html( $target->name ) .'</option>';
						    }
					    $output_target.='</select>';
					    echo $output_target;
					endif;
				?>
				</div>
				<div class="col-sm">
					<?php
					$donation_types = get_terms( array(
					    'taxonomy' => 'tipe_donasi',
					    'hide_empty' => false
					) );

					if ( !empty($donation_types) ) :
					    $output_donation_types = '<select name="tipe_donasi" class="form-control">';
							$output_donation_types.= '<option value="">Semua tipe donasi</option>';
						    foreach( $donation_types as $donation_type ) {
								$output_donation_types.= '<option value="'. esc_attr( $donation_type->slug ) .'">
									'. esc_html( $donation_type->name ) .'</option>';
						    }
					    $output_donation_types.='</select>';
					    echo $output_donation_types;
					endif;
					?>
				</div>
				<div class="col-sm p-l-0">
                    <input type="hidden" name="post_type" value="post" />
	    			<input type="submit" class="btn btn-primary btn-block btn-search" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
				</div>
			</div>
    	</form>
		<main id="main" class="site-main">
			<div class="row">
				<div class="col-lg-12">
					<?php
					$args = array(
					    'post_type' => 'post',
						'posts_per_page' => 10,
						'orderby' => 'title',
 						'order' => 'ASC',
						'paged' => ( get_query_var('page') ? get_query_var('page') : 1),
					);

					$query = new WP_Query( $args );

					if( get_query_var('page') ) {
						$paged_no = ( get_query_var('page')*$query->query_vars['posts_per_page'] ) - 9;
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
						        <th scope="col">Nama Penyalur</th>
						        <th scope="col">Daerah Penyaluran</th>
						        <th scope="col">Target</th>
						        <th scope="col">Tipe Donasi</th>
						        <th scope="col">Informasi Transfer</th>
						        <th scope="col">Kontak</th>
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
										<td><?php comma_separated_cat(get_the_ID(), 'target'); ?></td>
										<td><?php comma_separated_cat(get_the_ID(), 'tipe_donasi'); ?></td>
										<td><?php echo get_post_meta(get_the_ID(), 'rekening', true); ?></td>
										<td><?php echo get_post_meta(get_the_ID(), 'kontak', true); ?></td>
                                        <td>
											<a href="<?php echo get_post_meta(get_the_ID(), 'sumber', true); ?>">
												<?php echo get_post_meta(get_the_ID(), 'sumber', true); ?>
											</a>
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
									'current' => max( 1, get_query_var('page') ),
									'total' => $query->max_num_pages
								) );
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
