<?php

namespace LG\Testimonials\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonial extends AbstractDb {


	/**
	 * Initialize resource
	 *
	 * @return void
	 */
	public function _construct() {
		$this->_init( 'lg_testimonials', 'testimonial_id' );
	}


}

