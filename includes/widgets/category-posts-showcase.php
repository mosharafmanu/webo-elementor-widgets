<?php
namespace Webo_Elementor_Widgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Category_Posts_Showcase_Widget extends Widget_Base {
	public function get_name(): string {
		return 'webo-category-posts-showcase';
	}

	public function get_title(): string {
		return esc_html__( 'Webo Category Posts Showcase', 'webo-elementor-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-posts-carousel';
	}

	public function get_categories(): array {
		return [ 'webo-widgets' ];
	}

	public function get_keywords(): array {
		return [ 'webo', 'category', 'posts', 'showcase', 'carousel' ];
	}

	public function get_style_depends(): array {
		return [ 'webo-category-posts-showcase' ];
	}

	public function get_script_depends(): array {
		return [ 'webo-category-posts-showcase' ];
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Post Type', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_post_type_options(),
				'default' => 'post',
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_category_options(),
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type' => 'post',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 20,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'date'       => esc_html__( 'Date', 'webo-elementor-widgets' ),
					'title'      => esc_html__( 'Title', 'webo-elementor-widgets' ),
					'menu_order' => esc_html__( 'Menu Order', 'webo-elementor-widgets' ),
					'rand'       => esc_html__( 'Random', 'webo-elementor-widgets' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'DESC' => esc_html__( 'DESC', 'webo-elementor-widgets' ),
					'ASC'  => esc_html__( 'ASC', 'webo-elementor-widgets' ),
				],
				'default' => 'DESC',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel',
			[
				'label' => esc_html__( 'Carousel', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'enable_carousel',
			[
				'label'        => esc_html__( 'Enable Carousel', 'webo-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'webo-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'webo-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'          => esc_html__( 'Slides to Show', 'webo-elementor-widgets' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'condition'      => [
					'enable_carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'label'        => esc_html__( 'Show Arrows', 'webo-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'webo-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'webo-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'enable_carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'     => esc_html__( 'Animation Speed (ms)', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'min'       => 100,
				'step'      => 50,
				'condition' => [
					'enable_carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'        => esc_html__( 'Infinite Loop', 'webo-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'webo-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'webo-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'enable_carousel' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$query    = new \WP_Query( $this->get_query_args( $settings ) );

		if ( ! $query->have_posts() ) {
			return;
		}

		$this->enqueue_optional_carousel_assets( $settings, (int) $query->post_count );

		$enable_carousel = 'yes' === ( $settings['enable_carousel'] ?? '' ) && $query->post_count > 1;
		$show_arrows     = $enable_carousel && 'yes' === ( $settings['show_arrows'] ?? '' );

		$this->add_render_attribute(
			'wrapper',
			[
				'class'               => 'webo-category-posts-showcase',
				'data-carousel'       => $enable_carousel ? 'yes' : 'no',
				'data-arrows'         => $show_arrows ? 'yes' : 'no',
				'data-speed'          => (string) ( ! empty( $settings['speed'] ) ? absint( $settings['speed'] ) : 500 ),
				'data-infinite'       => 'yes' === ( $settings['infinite'] ?? '' ) ? 'yes' : 'no',
				'data-slides-desktop' => (string) $this->get_slides_to_show( $settings, 'desktop' ),
				'data-slides-tablet'  => (string) $this->get_slides_to_show( $settings, 'tablet' ),
				'data-slides-mobile'  => (string) $this->get_slides_to_show( $settings, 'mobile' ),
			]
		);

		$this->add_render_attribute(
			'track',
			'class',
			$enable_carousel
				? [ 'webo-category-posts-showcase__track', 'itemMargin', 'stagePaddingRight' ]
				: 'webo-category-posts-showcase__track'
		);
		?>
		<section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'track' ); ?>>
				<?php while ( $query->have_posts() ) : ?>
					<?php $query->the_post(); ?>
					<?php $this->render_post_card( get_post() ); ?>
				<?php endwhile; ?>
			</div>

			<?php if ( $show_arrows ) : ?>
					<div class="webo-category-posts-showcase__nav">
						<button class="webo-category-posts-showcase__nav-button webo-category-posts-showcase__nav-button--prev" type="button" aria-label="<?php echo esc_attr__( 'Previous posts', 'webo-elementor-widgets' ); ?>">
						<span aria-hidden="true"><?php echo $this->get_svg_icon_markup( 'long-arrow-left' ); ?></span>
					</button>
						<button class="webo-category-posts-showcase__nav-button webo-category-posts-showcase__nav-button--next" type="button" aria-label="<?php echo esc_attr__( 'Next posts', 'webo-elementor-widgets' ); ?>">
						<span aria-hidden="true"><?php echo $this->get_svg_icon_markup( 'long-arrow-right' ); ?></span>
					</button>
				</div>
			<?php endif; ?>
		</section>
		<?php

		wp_reset_postdata();
	}

	private function render_post_card( \WP_Post $post ): void {
		$permalink       = get_permalink( $post );
		$label           = $this->get_post_label( $post );
		$featured_image  = get_the_post_thumbnail(
			$post,
			'full',
			[
				'class'    => 'webo-category-posts-showcase__image-tag',
				'loading'  => 'lazy',
				'decoding' => 'async',
			]
		);

		if ( '' === $featured_image ) {
			$featured_image = sprintf(
				'<img class="webo-category-posts-showcase__image-tag" src="%1$s" alt="%2$s" loading="lazy" decoding="async">',
				esc_url( Utils::get_placeholder_image_src() ),
				esc_attr( get_the_title( $post ) )
			);
		}
		?>
		<article class="webo-category-posts-showcase__item">
			<div class="webo-category-posts-showcase__card">
				<a class="webo-category-posts-showcase__image" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( get_the_title( $post ) ); ?>">
					<?php echo wp_kses_post( $featured_image ); ?>
				</a>

				<div class="webo-category-posts-showcase__overlay"></div>

				<div class="webo-category-posts-showcase__content">
					<?php if ( '' !== $label ) : ?>
						<div class="webo-category-posts-showcase__label">/ <?php echo esc_html( $label ); ?> /</div>
					<?php endif; ?>

					<h3 class="webo-category-posts-showcase__title">
						<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
					</h3>

					<a class="webo-category-posts-showcase__cta" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( get_the_title( $post ) ); ?>">
						<span aria-hidden="true"><?php echo $this->get_svg_icon_markup( 'long-arrow-right' ); ?></span>
					</a>
				</div>
			</div>
		</article>
		<?php
	}

	private function get_query_args( array $settings ): array {
		$post_type      = ! empty( $settings['post_type'] ) ? sanitize_key( $settings['post_type'] ) : 'post';
		$categories     = ! empty( $settings['categories'] ) && is_array( $settings['categories'] ) ? array_filter( array_map( 'absint', $settings['categories'] ) ) : [];
		$posts_per_page = ! empty( $settings['posts_per_page'] ) ? absint( $settings['posts_per_page'] ) : 6;
		$orderby        = ! empty( $settings['orderby'] ) ? sanitize_key( $settings['orderby'] ) : 'date';
		$order          = ! empty( $settings['order'] ) ? strtoupper( sanitize_key( $settings['order'] ) ) : 'DESC';

		$args = [
			'post_type'           => $post_type,
			'posts_per_page'      => $posts_per_page,
			'orderby'             => $orderby,
			'order'               => in_array( $order, [ 'ASC', 'DESC' ], true ) ? $order : 'DESC',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		];

		if ( 'post' === $post_type && ! empty( $categories ) ) {
			$args['category__in'] = $categories;
		}

		return $args;
	}

	private function get_post_type_options(): array {
		$options    = [];
		$post_types = get_post_types( [ 'public' => true ], 'objects' );

		foreach ( $post_types as $slug => $post_type ) {
			if ( in_array( $slug, [ 'attachment', 'page', 'elementor_library', 'e-landing-page' ], true ) ) {
				continue;
			}

			$options[ $slug ] = $post_type->labels->singular_name;
		}

		return $options;
	}

	private function get_category_options(): array {
		$options    = [];
		$categories = get_terms(
			[
				'taxonomy'   => 'category',
				'hide_empty' => false,
			]
		);

		if ( is_wp_error( $categories ) || empty( $categories ) ) {
			return $options;
		}

		foreach ( $categories as $category ) {
			$options[ $category->term_id ] = $category->name;
		}

		return $options;
	}

	private function get_post_label( \WP_Post $post ): string {
		$terms = get_the_terms( $post, 'post_tag' );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return '';
		}

		return wp_strip_all_tags( $terms[0]->name );
	}

	private function get_slides_to_show( array $settings, string $device ): int {
		$key = 'slides_to_show';

		if ( 'tablet' === $device ) {
			$key = 'slides_to_show_tablet';
		}

		if ( 'mobile' === $device ) {
			$key = 'slides_to_show_mobile';
		}

		$value = ! empty( $settings[ $key ] ) ? absint( $settings[ $key ] ) : 0;

		if ( $value < 1 ) {
			return 'mobile' === $device ? 1 : 2;
		}

		return $value;
	}

	private function enqueue_optional_carousel_assets( array $settings, int $post_count ): void {
		if ( 'yes' !== ( $settings['enable_carousel'] ?? '' ) || $post_count < 2 ) {
			return;
		}

		if ( wp_style_is( 'webo-slick', 'registered' ) ) {
			wp_enqueue_style( 'webo-slick' );
		}

		if ( wp_script_is( 'webo-slick', 'registered' ) ) {
			wp_enqueue_script( 'webo-slick' );
		}
	}

	private function get_svg_icon_markup( string $icon_name ): string {
		$allowed_icons = [
			'long-arrow-left',
			'long-arrow-right',
		];

		if ( ! in_array( $icon_name, $allowed_icons, true ) ) {
			return '';
		}

		$icon_path = WEBO_ELEMENTOR_WIDGETS_PATH . 'assets/svgs/' . $icon_name . '.php';

		if ( ! file_exists( $icon_path ) ) {
			return '';
		}

		ob_start();
		include $icon_path;

		return (string) ob_get_clean();
	}
}