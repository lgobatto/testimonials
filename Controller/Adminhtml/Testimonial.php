<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 17:29
 */

namespace LG\Testimonials\Controller\Adminhtml;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Testimonial
 * @package LG\Testimonials\Controller\Adminhtml
 */
class Testimonial extends Action {

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;
	/**
	 * @var ForwardFactory
	 */
	protected $resultForwardFactory;
	/**
	 * @var \Magento\Framework\Controller\Result\RedirectFactory
	 */
	protected $resultRedirectFactory;

	/**
	 * Testimonial constructor.
	 *
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 * @param ForwardFactory $resultForwardFactory
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		ForwardFactory $resultForwardFactory
	) {
		$this->resultPageFactory     = $resultPageFactory;
		$this->resultForwardFactory  = $resultForwardFactory;
		$this->resultRedirectFactory = $context->getResultRedirectFactory();
		parent::__construct( $context );
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed() {
		return $this->_authorization->
		isAllowed( 'LG_Testimonials::testimonial_manage' );
	}

	/**
	 * @return $this
	 */
	protected function _initAction() {
		$this->_view->loadLayout();
		$this->_setActiveMenu(
			'LG_Testimonials::testimonial_manage'
		)->_addBreadcrumb(
			__( 'LG' ),
			__( 'Testimonials' )
		);

		return $this;
	}

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