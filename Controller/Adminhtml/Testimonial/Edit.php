<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 7/20/16
 * Time: 14:05
 */

namespace LG\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 * @package LG\Testimonials\Controller\Adminhtml\Testimonial
 */
class Edit extends Action {

	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $_coreRegistry = null;

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @param Action\Context $context
	 * @param PageFactory $resultPageFactory
	 * @param Registry $registry
	 */
	public function __construct(
		Action\Context $context,
		PageFactory $resultPageFactory,
		Registry $registry
	) {
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry     = $registry;
		parent::__construct( $context );
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _isAllowed() {
		return $this->_authorization->isAllowed( 'LG_Testimonials::save' );
	}

	/**
	 * Init actions
	 *
	 * @return \Magento\Backend\Model\View\Result\Page
	 */
	protected function _initAction() {
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu( 'LG_Testimonials::testimonial' )
		           ->addBreadcrumb( __( 'Testimonials' ), __( 'Testimonials' ) )
		           ->addBreadcrumb( __( 'Manage Testimonials' ), __( 'Manage Testimonials' ) );

		return $resultPage;
	}

	/**
	 * Dispatch request
	 *
	 * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
	 * @throws \Magento\Framework\Exception\NotFoundException
	 */
	public function execute() {
		$id    = $this->getRequest()->getParam( 'testimonial_id' );
		$model = $this->_objectManager->create( 'LG\Testimonials\Model\Testimonial' );

		if ( $id ) {
			$model->load( $id );
			if ( ! $model->getId() ) {
				$this->messageManager->addError( __( 'This testimonial no longer exists.' ) );
				/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
				$resultRedirect = $this->resultRedirectFactory->create();

				return $resultRedirect->setPath( '*/*/' );
			}
		}

		$data = $this->_objectManager->get( 'Magento\Backend\Model\Session' )->getFormData( true );
		if ( ! empty( $data ) ) {
			$model->setData( $data );
		}

		$this->_coreRegistry->register( 'testimonial', $model );

		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->_initAction();
		$resultPage->addBreadcrumb(
			$id ? __( 'Edit Testimonial' ) : __( 'New Testimonial' ),
			$id ? __( 'Edit Testimonial' ) : __( 'New Testimonial' )
		);
		$resultPage->getConfig()->getTitle()->prepend( __( 'Testimonials' ) );
		$resultPage->getConfig()->getTitle()
		           ->prepend( $model->getId() ? $model->getTitle() : __( 'New Testimonial' ) );

		return $resultPage;
	}
}