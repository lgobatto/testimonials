<?php

namespace LG\Testimonials\Model\ResourceModel\Testimonial;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	/**
	 * Initialize resource collection
	 *
	 * @return void
	 */
	public function _construct() {
		$this->_init( 'LG\Testimonials\Model\Testimonial', 'LG\Testimonials\Model\ResourceModel\Testimonial' );
	}
}
