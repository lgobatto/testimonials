<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 17:34
 */

namespace LG\Testimonials\Controller\Adminhtml\Testimonial;


use LG\Testimonials\Controller\Adminhtml\Testimonial;
use Magento\Framework\App\ResponseInterface;

class Index extends Testimonial {

	/**
	 * Dispatch request
	 *
	 * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
	 * @throws \Magento\Framework\Exception\NotFoundException
	 */
	public function execute() {
		if ( $this->getRequest()->getQuery( 'ajax' ) ) {
			$resultForward = $this->resultForwardFactory->create();
			$resultForward->forward( 'grid' );

			return $resultForward;
		}
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu( 'LG_Testimonials::testimonial' );
		$resultPage->getConfig()->getTitle()->prepend( __( 'Testimonials' ) );
		$resultPage->addBreadcrumb( __( 'Testimonials' ), __( 'Testimonials' ) );
		$resultPage->addBreadcrumb( __( 'Manage Testimonials' ), __( 'Manage Testimonials' ) );

		return $resultPage;
	}
}