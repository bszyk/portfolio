<?php

namespace PortfolioTheme\Pages;

/**
 * Render parts for front-page.php
 */
class FrontPage {

	/**
	 * CSS filter presets.
	 * @var array $filter_presets
	 */
	public $filter_presets = array(
		'watercolor'  => 'brightness(1.3) invert(0.17) saturate(2.6) sepia(0.25)',
		'faded-photo' => 'blur(0.2px) brightness(1.1) hue-rotate(5deg) opacity(0.9) saturate(1.3) sepia(0.4)',
		'old-grainy'  => 'grayscale(0.6) sepia(0.5) brightness(1.5)',
	);

	/**
	 * Construct.
	 */
	public function __construct() {
	}

	/**
	 * Output header portion of front page.
	 * @return string HTML
	 */
	public function header() {
		$style  = sprintf( 'background-image: url(%s);', esc_url( $this->getRandomBgImgUrl() ) );
		$style .= sprintf( 'filter: %s;', $this->getRandomCssFilterValue() );

		ob_start();
		?>
		<div class="front-page" id="front-page-background" style="<?php echo esc_attr( $style ); ?>">
		<?php
		return ob_flush();
	}

	/**
	 * Get URL of random background image.
	 * @return string Image URL
	 */
	public function getRandomBgImgUrl() {
		$query_images_args = array(
			'post_type'   => 'attachment',
			'tag'         => 'bg-img',
			'post_status' => 'inherit',
		);

		$query_images = new \WP_Query( $query_images_args );

		$images = array();
		foreach ( $query_images->posts as $image ) {
			$images[] = wp_get_attachment_image_src( $image->ID, 'large' );
		}

		$i = array_rand( $images );

		return $images[ $i ][0];
	}

	/**
	 * Get CSS filter value.
	 * @return string Filter value
	 */
	public function getRandomCssFilterValue() {
		$filters = array_values( $this->filter_presets );
		$i       = array_rand( $filters );
		return $filters[ $i ];
	}
}
