<?php
namespace Webo_Elementor_Widgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Demo_Widget extends Widget_Base {
	public function get_name(): string {
		return 'webo-demo-widget';
	}

	public function get_title(): string {
		return esc_html__( 'Webo Demo Card', 'webo-elementor-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-call-to-action';
	}

	public function get_categories(): array {
		return [ 'webo-widgets' ];
	}

	public function get_keywords(): array {
		return [ 'webo', 'demo', 'card', 'cta' ];
	}

	public function get_style_depends(): array {
		return [ 'webo-demo-widget' ];
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Badge', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Webo Widget', 'webo-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter badge text', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Build reusable sections faster', 'webo-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter widget title', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is a starter custom Elementor widget for the Webo project. Replace the content and expand the controls as your design system evolves.', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Learn More', 'webo-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter button text', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://mosharafmanu.com',
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'webo-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'webo-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'webo-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'webo-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .webo-demo-card' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .webo-demo-card__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .webo-demo-card__title',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .webo-demo-card__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button_link', $settings['button_link'] );
		}
		?>
		<div class="webo-demo-card">
			<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
				<span class="webo-demo-card__badge"><?php echo esc_html( $settings['badge_text'] ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $settings['title'] ) ) : ?>
				<h3 class="webo-demo-card__title"><?php echo esc_html( $settings['title'] ); ?></h3>
			<?php endif; ?>

			<?php if ( ! empty( $settings['description'] ) ) : ?>
				<div class="webo-demo-card__description"><?php echo wp_kses_post( wpautop( $settings['description'] ) ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['button_text'] ) ) : ?>
				<a class="webo-demo-card__button" <?php echo $this->get_render_attribute_string( 'button_link' ); ?>>
					<?php echo esc_html( $settings['button_text'] ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}