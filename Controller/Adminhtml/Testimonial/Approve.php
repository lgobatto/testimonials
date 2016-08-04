<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 20:41
 */

namespace LG\Testimonials\Controller\Adminhtml\Testimonial;


use LG\Testimonials\Model\Testimonial;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Approve extends Action {

	protected $_model;

	/**
	 * @param Context $context
	 * @param Testimonial $model
	 */
	public function __construct(
		Context $context,
		Testimonial $model
	) {
		parent::__construct( $context );
		$this->_model = $model;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _isAllowed() {
		return $this->_authorization->isAllowed( 'LG_Testimonials::testimonial_save' );
	}

	/**
	 * Dispatch request
	 *
	 * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
	 * @throws \Magento\Framework\Exception\NotFoundException
	 */
	public function execute() {
		$id = $this->getRequest()->getParam( 'testimonial_id' );
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();
		if ( $id ) {
			try {
				$model = $this->_model;
				$model->load( $id );
				$model->setStatus( $model::STATUS_APPROVED );
				$model->save();
				$this->messageManager->addSuccess( __( 'Testimonial approved' ) );

				return $resultRedirect->setPath( '*/*/' );
			} catch ( \Exception $e ) {
				$this->messageManager->addError( $e->getMessage() );

				return $resultRedirect->setPath( '*/*/edit', [ 'id' => $id ] );
			}
		}
		$this->messageManager->addError( __( 'Testimonial does not exist' ) );

		return $resultRedirect->setPath( '*/*/' );
	}
}