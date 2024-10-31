<?php
/**
 * Conditions for post categories.
 *
 * @package Publishing_Conditions
 */

namespace MauroBringolf\Publishing_Conditions;

require_once 'interface-conditions.php';

/**
 * Defines a number of conditions for post categories.
 */
class Category_Conditions implements Conditions {

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
				'name' => 'not_uncategorized',
				'title' => __( 'Not "Uncategorized"', 'publishing-conditions' ),
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
			case 'not_uncategorized':
				return $this->violates_not_uncategorized( $post_id );
				break;
		}
		return true;
	}

	/**
	 * Checks whether a post violates the not_uncategorized condition.
	 *
	 * @param Integer $post_id post to be checked.
	 */
	private function violates_not_uncategorized( $post_id ) {
		$categories = wp_get_post_categories( $post_id, array(
			'fields' => 'all',
		) );
		foreach ( $categories as $cat ) {
			if ( 'uncategorized' === $cat->slug ) {
				return true;
			}
		}
		return false;
	}
}
