<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 17:38
 */

namespace LG\Testimonials\Controller\Adminhtml\Testimonial;


use LG\Testimonials\Controller\Adminhtml\Testimonial;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Grid
 * @package LG\Testimonials\Controller\Adminhtml\Testimonial
 */
class Grid extends Testimonial {

	/**
	 * Dispatch request
	 *
	 * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
	 * @throws \Magento\Framework\Exception\NotFoundException
	 */
	public function execute() {
		$this->_view->loadLayout( false );
		$this->_view->renderLayout();
	}
}