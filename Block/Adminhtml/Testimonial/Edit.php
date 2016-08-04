<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 20:06
 */

namespace LG\Testimonials\Block\Adminhtml\Testimonial;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container {
	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $_coreRegistry = null;

	/**
	 * @param Context $context
	 * @param Registry $registry
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		Registry $registry,
		array $data = [ ]
	) {
		$this->_coreRegistry = $registry;
		parent::__construct( $context, $data );
	}

	/**
	 * Testimonial edit block
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_objectId   = 'testimonial_id';
		$this->_blockGroup = 'LG_Testimonials';
		$this->_controller = 'adminhtml_testimonial';

		parent::_construct();

		if ( $this->_isAllowedAction( 'LG_Testimonials::testimonial_save' ) ) {
			$this->buttonList->update( 'save', 'label', __( 'Save Testimonial' ) );
			$this->buttonList->add(
				'saveandcontinue',
				[
					'label'          => __( 'Save and Continue Edit' ),
					'class'          => 'save',
					'data_attribute' => [
						'mage-init' => [
							'button' => [ 'event' => 'saveAndContinueEdit', 'target' => '#edit_form' ],
						],
					]
				],
				- 100
			);
		} else {
			$this->buttonList->remove( 'save' );
		}

	}

	/**
	 * Get header with Testimonial name
	 *
	 * @return \Magento\Framework\Phrase
	 */
	public function getHeaderText() {
		if ( $this->_coreRegistry->registry( 'lg_testimonials_testimonial' )->getId() ) {
			return __( "Edit Testimonial " );
		} else {
			return __( 'New Testimonial' );
		}
	}

	/**
	 * Check permission for passed action
	 *
	 * @param string $resourceId
	 *
	 * @return bool
	 */
	protected function _isAllowedAction( $resourceId ) {
		return $this->_authorization->isAllowed( $resourceId );
	}

	/**
	 * Getter of url for "Save and Continue" button
	 * tab_id will be replaced by desired by JS later
	 *
	 * @return string
	 */
	protected function _getSaveAndContinueUrl() {
		return $this->getUrl( 'lg_testimonials/*/save', [ '_current' => true, 'back' => 'edit', 'active_tab' => '' ] );
	}
}