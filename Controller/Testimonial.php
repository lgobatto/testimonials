<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 15:14
 */

namespace LG\Testimonials\Controller;


use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\RequestInterface;

abstract class Testimonial extends Action {

	/**
	 * @var Session $customerSession
	 */
	protected $customerSession;

	/**
	 * Testimonial constructor.
	 *
	 * @param Context $context
	 * @param Session $customerSession
	 */
	public function __construct( Context $context, Session $customerSession ) {
		$this->customerSession = $customerSession;
		parent::__construct( $context );
	}

	/**
	 * @param RequestInterface $request
	 *
	 * @return \Magento\Framework\App\ResponseInterface
	 */
	function dispatch( RequestInterface $request ) {
		if ( ! $this->customerSession->authenticate() ) {
			$this->_actionFlag->set( '', 'no-dispatch', true );
			if ( ! $this->customerSession->getBeforeUrl() ) {
				$this->customerSession->setBeforeUrl( $this->_redirect->getRefererUrl() );
			}
		}

		return parent::dispatch( $request ); //
	}
}