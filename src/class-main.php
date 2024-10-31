<?php
/**
 * Main plugin class
 *
 * @package Publishing_Conditions
 */

namespace MauroBringolf\Publishing_Conditions;

require_once 'class-settings.php';
require_once 'class-category-conditions.php';
require_once 'class-tag-conditions.php';

/**
 * Connects all dependencies and manages plugin metadata.
 */
class Main {

	/**
	 * Singleton instance
	 *
	 * @var Main
	 */
	private static $instance;

	/**
	 * Returns the singleton
	 */
	static public function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Builds up dependencies
	 */
	private function __construct() {
		$this->category_conditions = new Category_Conditions();
		$this->tag_conditions = new Tag_Conditions();
		$this->settings = new Settings( $this->tag_conditions, $this->category_conditions );
	}

	/**
	 * Connects everything to hooks and filters
	 */
	public function run() {
		add_action( 'save_post', array( $this, 'add_pre_publish_check' ), 10, 3 );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'post_updated_messages', array( $this, 'change_post_published_message' ) );

		$this->settings->run();
	}

	/**
	 * Replaces "post updated" message with a notice that publishing conditions were not met.
	 *
	 * @param Array $messages Post update messages to be altered.
	 */
	public function change_post_published_message( $messages ) {
		if ( isset( $_GET['publishing_conditions_violated'] ) ) {
			$messages['post'][6] = __( 'Post saved but not published. It did not meet your publishing conditions.' , 'publishing-conditions' );
		}

		return $messages;
	}

	/**
	 * Loads the plugin textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'publishing-conditions', false, basename( dirname( dirname( __FILE__ ) ) ) . '/languages/' );
	}

	/**
	 * Add condition check into post saving process.
	 *
	 * @param Integer  $post_id Post to be saved.
	 * @param \WP_Post $post Post object to be saved.
	 * @param Bool     $update Whether this is an update of the post or not.
	 */
	public function add_pre_publish_check( $post_id, $post, $update ) {

		if ( 'post' === $post->post_type ) {
			if ( ! $update || 'publish' === $post->post_status ) {
				if ( ! $this->ready_for_publishing( $post_id ) ) {
					remove_action( 'save_post', array( $this, 'add_pre_publish_check' ) );
					add_filter( 'redirect_post_location', array( $this, 'add_notice_query_var' ), 99 );
					$this->set_draft( $post_id );
					add_action( 'save_post', array( $this, 'add_pre_publish_check' ), 10, 3 );
				}
			}
		}
	}

	/**
	 * Adds a query parameter indicating that the post was not published.
	 *
	 * @param Array $location Location to redirect to.
	 */
	public function add_notice_query_var( $location ) {
		remove_filter( 'redirect_post_location', array( $this, 'add_notice_query_var' ), 99 );
		return add_query_arg( array(
			'publishing_conditions_violated' => true,
		), $location );
	}

	/**
	 * Sets a post to draft.
	 *
	 * @param Integer $post_id Post to be updated.
	 */
	public function set_draft( $post_id ) {
		wp_update_post( array(
			'ID' => $post_id,
			'post_status' => 'draft',
		) );
	}

	/**
	 * Checks whether publishing conditions are met.
	 *
	 * @param Integer $post_id Post to be checked.
	 */
	public function ready_for_publishing( $post_id ) {

		$is_ready = true;

		$tag_condition = $this->settings->get_option( 'tag_conditions' );
		$category_condition = $this->settings->get_option( 'category_conditions' );

		$is_ready = $is_ready && ! $this->category_conditions->is_violated( $post_id, $category_condition );
		$is_ready = $is_ready && ! $this->tag_conditions->is_violated( $post_id, $tag_condition );

		return $is_ready;
	}
}
