<?php
/**
 * @package XML_Sitemaps
 */

if ( ! defined( 'WPSEO_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'WPSEO_Sitemaps_Admin' ) ) {
	/**
	 * Class that handles the Admin side of XML sitemaps
	 */
	class WPSEO_Sitemaps_Admin {

		/**
		 * Class constructor
		 */
		function __construct() {
			add_action( 'transition_post_status', array( $this, 'status_transition' ), 10, 3 );
			add_action( 'admin_init', array( $this, 'delete_sitemaps' ) );
		}

		/**
		 * Find sitemaps residing on disk as they will block our rewrite.
		 *
		 * @todo issue #561 https://github.com/Yoast/wordpress-seo/issues/561
		 */
		function delete_sitemaps() {
			$options = WPSEO_Options::get_all();
			if ( $options[ 'enablexmlsitemap' ] === true ) {

				$file_to_check_for = array(
					//ABSPATH . 'sitemap.xml',
					ABSPATH . 'sitemap_index.xml',
					//ABSPATH . 'sitemap.xslt',
					//ABSPATH . 'sitemap.xsl',
				);

				$new_files_found = false;

				foreach ( $file_to_check_for as $file ) {
					if ( ( $options['blocking_files'] === array() || ( $options['blocking_files'] !== array() && in_array( $file, $options[ 'blocking_files'] ) === false ) ) && file_exists( $file ) ) {
						$options['blocking_files'][] = $file;
						$new_files_found             = true;
					}
				}
				if ( $new_files_found === true ) {
					update_option( 'wpseo', $options );
				}
			}
		}

		/**
		 * Hooked into transition_post_status. Will initiate search engine pings
		 * if the post is being published, is a post type that a sitemap is built for
		 * and is a post that is included in sitemaps.
		 */
		function status_transition( $new_status, $old_status, $post ) {
			if ( $new_status != 'publish' )
				return;

			wp_cache_delete( 'lastpostmodified:gmt:' . $post->post_type, 'timeinfo' ); // #17455

			$options = WPSEO_Options::get_all();
			if ( isset( $options[ 'post_types-' . $post->post_type . '-not_in_sitemap' ] ) && $options[ 'post_types-' . $post->post_type . '-not_in_sitemap' ] === true ) {
				return;
			}

			if ( WP_CACHE ) {
				wp_schedule_single_event( time() + 300, 'wpseo_hit_sitemap_index' );
			}

			// Allow the pinging to happen slightly after the hit sitemap index so the sitemap is fully regenerated when the ping happens.
			if ( WPSEO_Meta::get_value( 'sitemap-include', $post->ID ) !== 'never' ) {
				if ( defined( 'YOAST_SEO_PING_IMMEDIATELY' ) && YOAST_SEO_PING_IMMEDIATELY ) {
					wpseo_ping_search_engines();
				}
				else {
					wp_schedule_single_event( ( time() + 300 ), 'wpseo_ping_search_engines' );
				}
			}
		}
	} /* End of class */

} /* End of class-exists wrapper */
