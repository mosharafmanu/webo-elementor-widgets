<?php
namespace Webo_Elementor_Widgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Testimonial_Card_Widget extends Widget_Base {
	public function get_name(): string {
		return 'webo-testimonial-card';
	}

	public function get_title(): string {
		return esc_html__( 'Webo Testimonial Card', 'webo-elementor-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories(): array {
		return [ 'webo-widgets' ];
	}

	public function get_keywords(): array {
		return [ 'webo', 'testimonial', 'review', 'carousel', 'card' ];
	}

	public function get_style_depends(): array {
		return [ 'webo-testimonial-card' ];
	}

	public function get_script_depends(): array {
		return [ 'webo-testimonial-card' ];
	}

	protected function register_controls(): void {
		$repeater = new Repeater();

		$repeater->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Heading', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'User opinions', 'webo-elementor-widgets' ),
				'rows'        => 3,
				'placeholder' => esc_html__( 'Enter heading', 'webo-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'quote',
			[
				'label'       => esc_html__( 'Quote', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'The vehicle was designed exactly for our needs — transparent, reliable, and prepared for every intervention.', 'webo-elementor-widgets' ),
				'rows'        => 5,
				'placeholder' => esc_html__( 'Enter testimonial text', 'webo-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'client_name',
			[
				'label'       => esc_html__( 'Name', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ime Priimek', 'webo-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter client name', 'webo-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'client_role',
			[
				'label'       => esc_html__( 'Role', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Function / Company', 'webo-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter client role', 'webo-elementor-widgets' ),
			]
		);

		$this->start_controls_section(
			'section_testimonials',
			[
				'label' => esc_html__( 'Testimonials', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => esc_html__( 'Items', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'heading'     => esc_html__( 'Mnenja uporabnikov', 'webo-elementor-widgets' ),
						'quote'       => esc_html__( 'Vozilo je zasnovano točno po naših potrebah – pregledno, zanesljivo in pripravljeno na vsako intervencijo. Ekipa WEBO nas je poslušala na vsakem koraku.', 'webo-elementor-widgets' ),
						'client_name' => esc_html__( 'Ime Priimek', 'webo-elementor-widgets' ),
						'client_role' => esc_html__( 'Funkcija LOREM Ipsum', 'webo-elementor-widgets' ),
					],
					[
						'heading'     => esc_html__( 'Trusted by crews', 'webo-elementor-widgets' ),
						'quote'       => esc_html__( 'From planning to delivery, the process was smooth and collaborative. The result is a vehicle we can rely on every day.', 'webo-elementor-widgets' ),
						'client_name' => esc_html__( 'John Doe', 'webo-elementor-widgets' ),
						'client_role' => esc_html__( 'Operations Manager', 'webo-elementor-widgets' ),
					],
				],
				'title_field' => '{{{ client_name }}}',
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
			'show_dots',
			[
				'label'        => esc_html__( 'Show Dots', 'webo-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'webo-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'webo-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'enable_carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'webo-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'webo-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'webo-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'enable_carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'step'      => 100,
				'condition' => [
					'enable_carousel' => 'yes',
					'autoplay'        => 'yes',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'     => esc_html__( 'Animation Speed (ms)', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 600,
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
		$items    = $settings['testimonials'] ?? [];

		if ( empty( $items ) ) {
			return;
		}

		$this->enqueue_optional_carousel_assets( $settings );

		$enable_carousel  = 'yes' === ( $settings['enable_carousel'] ?? '' );
		$has_many_items   = count( $items ) > 1;
		$show_navigation  = $enable_carousel && $has_many_items;
		$show_arrows      = $show_navigation && 'yes' === ( $settings['show_arrows'] ?? '' );
		$show_dots        = $show_navigation && 'yes' === ( $settings['show_dots'] ?? '' );
		$autoplay_speed   = ! empty( $settings['autoplay_speed'] ) ? absint( $settings['autoplay_speed'] ) : 5000;
		$animation_speed  = ! empty( $settings['speed'] ) ? absint( $settings['speed'] ) : 600;

		$this->add_render_attribute(
			'wrapper',
			[
				'class'                => 'webo-testimonial-card',
				'data-carousel'        => $show_navigation ? 'yes' : 'no',
				'data-arrows'          => $show_arrows ? 'yes' : 'no',
				'data-dots'            => $show_dots ? 'yes' : 'no',
				'data-autoplay'        => 'yes' === ( $settings['autoplay'] ?? '' ) ? 'yes' : 'no',
				'data-autoplay-speed'  => (string) $autoplay_speed,
				'data-speed'           => (string) $animation_speed,
				'data-infinite'        => 'yes' === ( $settings['infinite'] ?? '' ) ? 'yes' : 'no',
			]
		);
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="webo-testimonial-card__track">
				<?php foreach ( $items as $item ) : ?>
					<?php $this->render_slide( $item ); ?>
				<?php endforeach; ?>
			</div>

			<?php if ( $show_navigation && ( $show_arrows || $show_dots ) ) : ?>
				<div class="webo-testimonial-card__navigation">
					<?php if ( $show_dots ) : ?>
						<div class="webo-testimonial-card__dots"></div>
					<?php endif; ?>

					<?php if ( $show_arrows ) : ?>
						<div class="webo-testimonial-card__arrows">
							<button class="webo-testimonial-card__arrow webo-testimonial-card__arrow--prev" type="button" aria-label="<?php echo esc_attr__( 'Previous testimonial', 'webo-elementor-widgets' ); ?>">
								<span aria-hidden="true"><?php echo $this->get_svg_icon_markup( 'long-arrow-left' ); ?></span>
							</button>
							<button class="webo-testimonial-card__arrow webo-testimonial-card__arrow--next" type="button" aria-label="<?php echo esc_attr__( 'Next testimonial', 'webo-elementor-widgets' ); ?>">
								<span aria-hidden="true"><?php echo $this->get_svg_icon_markup( 'long-arrow-right' ); ?></span>
							</button>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	private function render_slide( array $item ): void {
		$image_id  = ! empty( $item['image']['id'] ) ? absint( $item['image']['id'] ) : 0;
		$image_url = ! empty( $item['image']['url'] ) ? $item['image']['url'] : '';
		$image_alt = ! empty( $item['client_name'] ) ? $item['client_name'] : ( $item['heading'] ?? '' );
		?>
		<article class="webo-testimonial-card__slide">
			<div class="webo-testimonial-card__image">
				<?php if ( $image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'full',
						false,
						[
							'class'    => 'webo-testimonial-card__image-tag',
							'loading'  => 'lazy',
							'decoding' => 'async',
							'alt'      => $image_alt,
						]
					);
					?>
				<?php elseif ( $image_url ) : ?>
					<img class="webo-testimonial-card__image-tag" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy" decoding="async">
				<?php endif; ?>
			</div>
			<div class="webo-testimonial-card__panel">
				<?php if ( ! empty( $item['heading'] ) ) : ?>
					<h3 class="webo-testimonial-card__heading"><?php echo wp_kses_post( nl2br( esc_html( $item['heading'] ) ) ); ?></h3>
				<?php endif; ?>

				<div class="webo-testimonial-card__body">
					<div class="webo-testimonial-card__divider"></div>

					<?php if ( ! empty( $item['quote'] ) ) : ?>
						<div class="webo-testimonial-card__quote"><?php echo wp_kses_post( wpautop( $item['quote'] ) ); ?></div>
					<?php endif; ?>

					<div class="webo-testimonial-card__meta">
						<?php if ( ! empty( $item['client_name'] ) ) : ?>
							<div class="webo-testimonial-card__name"><?php echo esc_html( $item['client_name'] ); ?></div>
						<?php endif; ?>

						<?php if ( ! empty( $item['client_role'] ) ) : ?>
							<div class="webo-testimonial-card__role"><?php echo esc_html( $item['client_role'] ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</article>
		<?php
	}

	private function enqueue_optional_carousel_assets( array $settings ): void {
		if ( 'yes' !== ( $settings['enable_carousel'] ?? '' ) ) {
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