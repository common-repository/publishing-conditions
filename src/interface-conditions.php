<?php
/**
 * Conditions interface for built-in conditions
 *
 * @package Publishing_Conditions
 */

namespace MauroBringolf\Publishing_Conditions;

interface Conditions {

	/**
	 * Should return all possible conditions as arrays with 'name' and 'title' property.
	 *
	 * @return Array
	 */
	public function value_range();

	/**
	 * Should return whether a post violates a condition.
	 *
	 * @param Integer $post_id post to be checked.
	 * @param String  $condition Name of the condition to be checked.
	 *
	 * @return Array
	 */
	public function is_violated( $post_id, $condition );
}
