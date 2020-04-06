<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Portal_Donasi
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="row">
				<div class="col-lg-12">
					<?php
					$args = array(
					    'post_type' => 'post',
						'posts_per_page' => 2,
						'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
					);
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) {
					?>
					<div class="table-responsive-lg">
						<table class="table">
							<thead>
						      <tr>
						        <th scope="col">#</th>
						        <th scope="col">Nama Penyalur</th>
						        <th scope="col">Daerah Penyaluran</th>
						        <th scope="col">Target</th>
						        <th scope="col">Tipe Donasi</th>
						        <th scope="col">Informasi Transfer</th>
						        <th scope="col">Kontak</th>
						      </tr>
						    </thead>
						    <tbody>
								<?php
									while ( $query->have_posts() ) {
										$query->the_post();
								?>
									<tr>
										<th scope="row">1</th>
										<td><?php echo get_the_title(); ?></td>
										<td><?php comma_separated_cat(get_the_ID(), 'category'); ?></td>
										<td><?php comma_separated_cat(get_the_ID(), 'target'); ?></td>
										<td><?php comma_separated_cat(get_the_ID(), 'tipe_donasi'); ?></td>
										<td>Cell</td>
										<td>Cell</td>
									</tr>
								<?php } ?>
						</table>
					</div>
					<?php
					$big = 999999999; // need an unlikely integer

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'prev_text'          => __(' Previous'),
						'next_text'          => __('Next '),
						'current' => max( 1, get_query_var('paged') ),
						'total' => $query->max_num_pages
					) );
					}
					?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
