<?php
namespace Webo_Elementor_Widgets;

use Elementor\Elements_Manager;
use Elementor\Widgets_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	private const MINIMUM_ELEMENTOR_VERSION = '3.5.0';
	private const MINIMUM_PHP_VERSION       = '7.4';

	private static ?Plugin $instance = null;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init(): void {
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
			return;
		}

		if ( version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		add_action( 'init', [ $this, 'load_textdomain' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function load_textdomain(): void {
		load_plugin_textdomain(
			'webo-elementor-widgets',
			false,
			dirname( plugin_basename( WEBO_ELEMENTOR_WIDGETS_FILE ) ) . '/languages'
		);
	}

	public function register_category( Elements_Manager $elements_manager ): void {
		$category = [
			'title' => esc_html__( 'Webo Widgets', 'webo-elementor-widgets' ),
			'icon'  => 'fa fa-plug',
		];

		$elements_manager->add_category( 'webo-widgets', $category );
		$this->move_category_after( $elements_manager, 'webo-widgets', $category, 'basic' );
	}

	private function move_category_after( Elements_Manager $elements_manager, string $category_name, array $category, string $after_category ): void {
		$categories = $elements_manager->get_categories();

		if ( isset( $categories[ $category_name ] ) ) {
			$category = $categories[ $category_name ];
			unset( $categories[ $category_name ] );
		}

		$category_keys   = array_keys( $categories );
		$anchor_position = array_search( $after_category, $category_keys, true );

		if ( false === $anchor_position ) {
			$reordered_categories = array_merge(
				[ $category_name => $category ],
				$categories
			);
		} else {
			$before_anchor = array_slice( $categories, 0, $anchor_position + 1, true );
			$after_anchor  = array_slice( $categories, $anchor_position + 1, null, true );

			$reordered_categories = $before_anchor + [ $category_name => $category ] + $after_anchor;
		}

		$reflection = new \ReflectionClass( $elements_manager );
		$property   = $reflection->getProperty( 'categories' );
		$property->setAccessible( true );
		$property->setValue( $elements_manager, $reordered_categories );
	}

	public function register_styles(): void {
		wp_register_style(
			'webo-demo-widget',
			WEBO_ELEMENTOR_WIDGETS_URL . 'assets/css/demo-widget.css',
			[ 'elementor-frontend' ],
			WEBO_ELEMENTOR_WIDGETS_VERSION
		);

		wp_register_style(
			'webo-testimonial-card',
			WEBO_ELEMENTOR_WIDGETS_URL . 'assets/css/testimonial-card.css',
			[ 'elementor-frontend' ],
			WEBO_ELEMENTOR_WIDGETS_VERSION
		);

		wp_register_style(
			'webo-home-blog-widget',
			WEBO_ELEMENTOR_WIDGETS_URL . 'assets/css/home-blog-widget.css',
			[ 'elementor-frontend' ],
			WEBO_ELEMENTOR_WIDGETS_VERSION
		);

		$this->register_optional_style(
			'webo-slick',
			[
				'assets/vendor/slick/slick.css',
			]
		);
	}

	public function register_scripts(): void {
		$this->register_optional_script(
			'webo-slick',
			[
				'assets/vendor/slick/slick.js',
			],
			[ 'jquery' ]
		);

		wp_register_script(
			'webo-testimonial-card',
			WEBO_ELEMENTOR_WIDGETS_URL . 'assets/js/testimonial-card.js',
			[ 'jquery' ],
			WEBO_ELEMENTOR_WIDGETS_VERSION,
			true
		);

		wp_register_script(
			'webo-home-blog-widget',
			WEBO_ELEMENTOR_WIDGETS_URL . 'assets/js/home-blog-widget.js',
			[ 'jquery' ],
			WEBO_ELEMENTOR_WIDGETS_VERSION,
			true
		);
	}

	public function register_widgets( Widgets_Manager $widgets_manager ): void {
		require_once WEBO_ELEMENTOR_WIDGETS_PATH . 'includes/widgets/class-demo-widget.php';
		require_once WEBO_ELEMENTOR_WIDGETS_PATH . 'includes/widgets/class-testimonial-card-widget.php';
		require_once WEBO_ELEMENTOR_WIDGETS_PATH . 'includes/widgets/class-home-blog-widget.php';

		$widgets_manager->register( new Widgets\Demo_Widget() );
		$widgets_manager->register( new Widgets\Testimonial_Card_Widget() );
		$widgets_manager->register( new Widgets\Home_Blog_Widget() );
	}

	private function register_optional_style( string $handle, array $relative_paths ): void {
		$asset = $this->locate_asset( $relative_paths );

		if ( null === $asset ) {
			return;
		}

		wp_register_style( $handle, $asset['url'], [], $asset['version'] );
	}

	private function register_optional_script( string $handle, array $relative_paths, array $dependencies = [] ): void {
		$asset = $this->locate_asset( $relative_paths );

		if ( null === $asset ) {
			return;
		}

		wp_register_script( $handle, $asset['url'], $dependencies, $asset['version'], true );
	}

	private function locate_asset( array $relative_paths ): ?array {
		foreach ( $relative_paths as $relative_path ) {
			$absolute_path = WEBO_ELEMENTOR_WIDGETS_PATH . $relative_path;

			if ( ! file_exists( $absolute_path ) ) {
				continue;
			}

			return [
				'url'     => WEBO_ELEMENTOR_WIDGETS_URL . $relative_path,
				'version' => (string) filemtime( $absolute_path ),
			];
		}

		return null;
	}

	public function admin_notice_missing_elementor(): void {
		$this->render_admin_notice(
			sprintf(
				/* translators: 1: Plugin name, 2: Elementor. */
				esc_html__( '%1$s requires %2$s to be installed and activated.', 'webo-elementor-widgets' ),
				'<strong>' . esc_html__( 'Webo Elementor Widgets', 'webo-elementor-widgets' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'webo-elementor-widgets' ) . '</strong>'
			)
		);
	}

	public function admin_notice_minimum_elementor_version(): void {
		$this->render_admin_notice(
			sprintf(
				/* translators: 1: Plugin name, 2: Minimum Elementor version. */
				esc_html__( '%1$s requires Elementor version %2$s or greater.', 'webo-elementor-widgets' ),
				'<strong>' . esc_html__( 'Webo Elementor Widgets', 'webo-elementor-widgets' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			)
		);
	}

	public function admin_notice_minimum_php_version(): void {
		$this->render_admin_notice(
			sprintf(
				/* translators: 1: Plugin name, 2: Minimum PHP version. */
				esc_html__( '%1$s requires PHP version %2$s or greater.', 'webo-elementor-widgets' ),
				'<strong>' . esc_html__( 'Webo Elementor Widgets', 'webo-elementor-widgets' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			)
		);
	}

	private function render_admin_notice( string $message ): void {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		printf( '<div class="notice notice-warning"><p>%s</p></div>', wp_kses_post( $message ) );
	}
}