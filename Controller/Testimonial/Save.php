<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 16:31
 */

namespace LG\Testimonials\Controller\Testimonial;


use LG\Testimonials\Controller\Testimonial;
use LG\Testimonials\Model\TestimonialFactory;
use Magento\Customer\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Save
 * @package LG\Testimonials\Controller\Testimonial
 */
class Save extends Testimonial {
	/**
	 * @var TransportBuilder $transportBuilder
	 */
	protected $transportBuilder;
	/**
	 * @var StateInterface $inlineTranslation
	 */
	protected $inlineTranslation;
	/**
	 * @var ScopeConfigInterface $scopeConfig
	 */
	protected $scopeConfig;
	/**
	 * @var StoreManagerInterface $storeManager
	 */
	protected $storeManager;
	/**
	 * @var Context
	 */
	private $context;
	/**
	 * @var Validator $formKeyValidator
	 */
	protected $formKeyValidator;
	/**
	 * @var DateTime $dateTime
	 */
	protected $dateTime;
	/**
	 * @var TestimonialFactory $testimonialFactory
	 */
	protected $testimonialFactory;

	/**
	 * Save constructor.
	 *
	 * @param Context $context
	 * @param Session $customerSession
	 * @param TransportBuilder $transportBuilder
	 * @param StateInterface $inlineTranslation
	 * @param ScopeConfigInterface $scopeConfig
	 * @param StoreManagerInterface $storeManager
	 * @param Validator $formKeyValidator
	 * @param DateTime $dateTime
	 * @param TestimonialFactory $testimonialFactory
	 */
	public function __construct(
		Context $context,
		Session $customerSession,
		TransportBuilder $transportBuilder,
		StateInterface $inlineTranslation,
		ScopeConfigInterface $scopeConfig,
		StoreManagerInterface $storeManager,
		Validator $formKeyValidator,
		DateTime $dateTime,
		TestimonialFactory $testimonialFactory
	) {
		$this->context            = $context;
		$this->customerSession    = $customerSession;
		$this->transportBuilder   = $transportBuilder;
		$this->inlineTranslation  = $inlineTranslation;
		$this->scopeConfig        = $scopeConfig;
		$this->storeManager       = $storeManager;
		$this->formKeyValidator   = $formKeyValidator;
		$this->dateTime           = $dateTime;
		$this->testimonialFactory = $testimonialFactory;
		$this->messageManager     = $context->getMessageManager();
		parent::__construct( $context, $customerSession );
	}

	/**
	 * Dispatch request
	 *
	 * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
	 * @throws \Magento\Framework\Exception\NotFoundException
	 */
	public function execute() {
		$resultRedirect = $this->resultRedirectFactory->create();
		if ( ! $this->formKeyValidator->validate( $this->getRequest() ) ) {
			return $resultRedirect->setRefererUrl();
		}
		$testimony = $this->getRequest()->getParam( 'testimony' );
		try {
			$testimonial = $this->testimonialFactory->create();
			$testimonial->setCustomerId( $this->customerSession->getCustomerId() );
			$testimonial->setTestimony( $testimony );
			$testimonial->setCreatedAt( $this->dateTime->formatDate( true ) );
			$testimonial->setStatus( \LG\Testimonials\Model\Testimonial::STATUS_AWAITING );
			$testimonial->save();

		} catch ( Exception $e ) {
			$this->messageManager->addError( __( 'Error occurred during testimonial creation.' ) );
		}

		return $resultRedirect->setRefererUrl();
	}
}