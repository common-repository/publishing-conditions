<?php
/**
 * Conditions for post tags.
 *
 * @package Publishing_Conditions
 */

namespace MauroBringolf\Publishing_Conditions;

require_once 'interface-conditions.php';

/**
 * Defines a number of conditions for post tags.
 */
class Tag_Conditions implements Conditions {

	/**
	 * Returns all conditions
	 */
	public function value_range() {
		return array(
			array(
				'name' => 'none',
				'title' => __( 'No conditions', 'publishing-conditions' ),
			),
			array(
				'name' => 'at_least_one',
				'title' => __( 'At least one', 'publishing-conditions' ),
			),
		);
	}

	/**
	 * Checks if a given post violates a condition
	 *
	 * @param Integer $post_id post to be checked.
	 * @param String  $condition name of the condition to be checked.
	 */
	public function is_violated( $post_id, $condition ) {
		switch ( $condition ) {
			case 'none':
				return false;
				break;
			case 'at_least_one':
				return $this->violates_at_least_one( $post_id );
				break;
		}
	}

	/**
	 * Checks whether a post violates the at_least_one condition.
	 *
	 * @param Integer $post_id post to be checked.
	 */
	private function violates_at_least_one( $post_id ) {
		$tags = wp_get_post_tags( $post_id );
		return count( $tags ) === 0;
	}
}
