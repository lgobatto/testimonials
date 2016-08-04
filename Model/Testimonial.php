<?php

namespace LG\Testimonials\Model;

use Magento\Framework\App\ObjectManager;
use \Magento\Framework\Model\AbstractModel;

/**
 * Class Testimonial
 * @package LG\Testimonials\Model
 */
class Testimonial extends AbstractModel {

	/**
	 * Constants definition
	 */
	const STATUS_APPROVED = 1;
	const STATUS_AWAITING = 0;

	/**
	 * @var array
	 */
	protected static $statuses_options = [
		self::STATUS_APPROVED => "Approved",
		self::STATUS_AWAITING => "Awaiting"
	];

	/**
	 * Initialize resource model
	 * @return void
	 */
	public function _construct() {
		$this->_init( 'LG\Testimonials\Model\ResourceModel\Testimonial' );
	}

	function getCustomerAsLabel() {
		/**
		 * @var \Magento\Customer\Model\Customer $customer
		 */
		$customer = ObjectManager::getInstance()->create( 'Magento\Customer\Model\Customer' )->load( $this->getCustomerId() );

		return $customer->getName();
	}

	function getStatusAsLabel() {
		return self::$statuses_options[ $this->getStatus() ];
	}

	static function getStatusOptionsArray() {
		return self::$statuses_options;
	}

}

