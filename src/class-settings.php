<?php
/**
 * Settings class
 *
 * @package Publishing_Conditions
 */

namespace MauroBringolf\Publishing_Conditions;

/**
 * Manages all options of this plugin
 */
class Settings {

	/**
	 * Connects everything to hooks and filters
	 */
	public function run() {
		add_action( 'admin_init', array( $this, 'setup' ) );
	}

	/**
	 * Setup references to dependencies
	 *
	 * @param Tag_Conditions      $tag_conditions Conditions for tags.
	 * @param Category_Conditions $category_conditions Conditions for categories.
	 */
	public function __construct( Tag_Conditions $tag_conditions, Category_Conditions $category_conditions ) {
		$this->tag_conditions = $tag_conditions;
		$this->category_conditions = $category_conditions;
	}

	/**
	 * Registers options with the Settings API
	 */
	public function setup() {

		register_setting( 'writing', 'mbch_publishing_conditions', array( $this, 'sanitize' ) );

		add_settings_section(
			'mbch-publishing-conditions',
			__( 'Publishing Conditions', 'publishing-conditions' ),
			array( $this, 'render_section' ),
			'writing'
		);

		add_settings_field(
			'category_conditions',
			__( 'Categories', 'publishing-conditions' ),
			array( $this, 'category_conditions' ),
			'writing',
			'mbch-publishing-conditions'
		);

		add_settings_field(
			'tag_conditions',
			__( 'Tags', 'publishing-conditions' ),
			array( $this, 'tag_conditions' ),
			'writing',
			'mbch-publishing-conditions'
		);

	}

	/**
	 * Displays a short settings description
	 */
	public function render_section() {
		?>
		<p><?php _e( 'Define publishing conditions for your posts.', 'publishing-conditions' ); ?></p>
		<?php
	}

	/**
	 * Displays option markup
	 */
	public function category_conditions() {

		$field = 'category_conditions';
		$value = $this->get_option( $field );
		?>

		<select name="mbch_publishing_conditions[category_conditions]">
			<?php foreach ( $this->category_conditions->value_range() as $condition ) : ?>
			<option <?php selected( $condition['name'], $value ); ?> value="<?php echo $condition['name']; ?>"><?php echo $condition['title']; ?></option>
			<?php endforeach; ?>
		</select>

		<?php
	}

	/**
	 * Displays option markup
	 */
	public function tag_conditions() {

		$field = 'tag_conditions';
		$value = $this->get_option( $field );
		?>

		<select name="mbch_publishing_conditions[tag_conditions]">
			<?php foreach ( $this->tag_conditions->value_range() as $condition ) : ?>
			<option <?php selected( $condition['name'], $value ); ?> value="<?php echo $condition['name']; ?>"><?php echo $condition['title']; ?></option>
			<?php endforeach; ?>
		</select>

		<?php
	}

	/**
	 * Settings helper to retrieve fields from serialized option
	 *
	 * @param String $name option to be retrieved.
	 */
	public function get_option( $name ) {
		$options = get_option( 'mbch_publishing_conditions' );
		$options = wp_parse_args(
			$options,
			array(
				'category_conditions' => 'none',
				'tag_conditions' => 'none',
			)
		);
		return $options[ $name ];
	}

	/**
	 * Applies sanitize_text_field and checks against defaults.
	 *
	 * @param Array $data Settings to be sanitized.
	 */
	public function sanitize( $data ) {
		$sanitized = array_map( 'sanitize_text_field', $data );

		return wp_parse_args( $sanitized, array(
			'category_conditions' => 'none',
			'tag_conditions' => 'none',
		));
	}
}
