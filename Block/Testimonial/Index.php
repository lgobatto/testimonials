<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 15:29
 */

namespace LG\Testimonials\Block\Testimonial;


use LG\Testimonials\Model\TestimonialFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Index
 * @package LG\Testimonials\Block\Testimonial
 */
class Index extends Template {
	/**
	 * @var DateTime
	 */
	protected $dateTime;
	/**
	 * @var Session
	 */
	protected $customerSession;
	/**
	 * @var \LG\Testimonials\Model\TestimonialFactory
	 */
	protected $testimonialFactory;

	/**
	 * Index constructor.
	 *
	 * @param Context $context
	 * @param DateTime $dateTime
	 * @param Session $customerSession
	 * @param TestimonialFactory $testimonialFactory
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		DateTime $dateTime,
		Session $customerSession,
		TestimonialFactory $testimonialFactory,
		array $data = [ ]
	) {
		$this->dateTime        = $dateTime;
		$this->customerSession = $customerSession;
		$this->testimonialFactory   = $testimonialFactory;
		parent::__construct( $context, $data );
	}

	function getTestimonials() {
		return $this->testimonialFactory->create()
		                                ->getCollection()
		                                ->addFieldToFilter( 'customer_id', $this->customerSession->getCustomerId() );
	}
}