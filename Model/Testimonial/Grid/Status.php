<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 18:31
 */

namespace LG\Testimonials\Model\Testimonial\Grid;


use LG\Testimonials\Model\Testimonial;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package LG\Testimonials\Model\Testimonial\Grid
 */
class Status implements ArrayInterface {

	/**
	 * Return array of options as value-label pairs
	 *
	 * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
	 */
	public function toOptionArray() {
		return Testimonial::getStatusOptionsArray();
	}
}