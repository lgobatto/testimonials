<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 20:19
 */

namespace LG\Testimonials\Block\Adminhtml\Testimonial\Edit;

use Magento\Backend\Block\Template\Context;
use \Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

class Form extends Generic {
	/**
	 * @var Store
	 */
	protected $_systemStore;

	/**
	 * @param Context $context
	 * @param Registry $registry
	 * @param FormFactory $formFactory
	 * @param Store $systemStore
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		Store $systemStore,
		array $data = [ ]
	) {
		$this->_systemStore = $systemStore;
		parent::__construct( $context, $registry, $formFactory, $data );
	}

	/**
	 * Init form
	 *
	 * @return void
	 */
	protected function _construct() {
		parent::_construct();
		$this->setId( 'testimonial_form' );
		$this->setTitle( __( 'Testimonial Information' ) );
	}

	/**
	 * @param $storeId
	 *
	 * @return array
	 */
	public function loadCustomers( $storeId ) {
		/**
		 * @var \Magento\Customer\Model\ResourceModel\Customer\Collection $customers
		 */
		$customers         = ObjectManager::getInstance()->create( '\Magento\Customer\Model\ResourceModel\Customer\Collection' );
		$customers_options = $customers
			->removeAllFieldsFromSelect()
			->addFieldToSelect( 'entity_id', 'id' )
			->addExpressionAttributeToSelect(
				'name',
				'CONCAT({{firstname}}, " ", {{lastname}})',
				[
					'firstname',
					'lastname'
				]
			)->addFilter(
				'store_id',
				$storeId
			)->toOptionArray();

		return $customers_options;
	}

	/**
	 * Prepare form
	 *
	 * @return $this
	 */
	protected function _prepareForm() {
		/** @var \LG\Testimonials\Model\Testimonial $model */
		$model = $this->_coreRegistry->registry( 'testimonial' );

		/** @var \Magento\Framework\Data\Form $form */
		$form = $this->_formFactory->create(
			[ 'data' => [ 'id' => 'edit_form', 'action' => $this->getData( 'action' ), 'method' => 'post' ] ]
		);

		$form->setHtmlIdPrefix( 'testimonial_' );

		$fieldset = $form->addFieldset(
			'base_fieldset',
			[ 'legend' => __( 'General Information' ), 'class' => 'fieldset-wide' ]
		);

		if ( $model->getId() ) {
			$fieldset->addField( 'testimonial_id', 'hidden', [ 'name' => 'testimonial_id' ] );
		}

		/**
		 * @var int $storeId
		 */
		$storeId = $this->_storeManager->getStore()->getId();
		$fieldset->addField(
			'customer_id',
			'select',
			[
				'name'     => 'customer_id',
				'label'    => __( 'Customer' ),
				'title'    => __( 'Customer' ),
				'required' => true,
				'values'   => $this->loadCustomers( $storeId )
			]
		);

		$fieldset->addField(
			'testimony',
			'textarea',
			[
				'name'     => 'testimony',
				'label'    => __( 'Testimony' ),
				'title'    => __( 'Testimony' ),
				'required' => true
			]
		);

		$fieldset->addField(
			'status',
			'select',
			[
				'label'    => __( 'Status' ),
				'title'    => __( 'Status' ),
				'name'     => 'status',
				'required' => true,
				'options'  => $model::getStatusOptionsArray()
			]
		);

		$form->setValues( $model->getData() );
		$form->setUseContainer( true );
		$this->setForm( $form );

		return parent::_prepareForm();
	}
}