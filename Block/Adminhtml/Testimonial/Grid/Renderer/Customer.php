<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 17:26
 */

namespace LG\Testimonials\Block\Adminhtml\Testimonial\Grid\Renderer;


use LG\Testimonials\Model\TestimonialFactory;
use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

/**
 * Class Status
 * @package LG\Testimonials\Block\Adminhtml\Testimonial\Grid\Renderer
 */
class Customer extends AbstractRenderer {
	/**
	 * @var TestimonialFactory
	 */
	protected $testimonialFactory;

	/**
	 * Status constructor.
	 *
	 * @param Context $context
	 * @param TestimonialFactory $testimonialFactory
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		TestimonialFactory $testimonialFactory,
		array $data = [ ]
	) {
		parent::__construct( $context, $data );
		$this->testimonialFactory = $testimonialFactory;
	}

	/**
	 * @param \Magento\Framework\DataObject $row
	 *
	 * @return string
	 */
	public function render( \Magento\Framework\DataObject $row ) {
		$testimonial = $this->testimonialFactory->create()->load( $row->getId() );
		if ( $testimonial && $testimonial->getId() ) {
			return $testimonial->getCustomerAsLabel();
		}

		return '';
	}
}