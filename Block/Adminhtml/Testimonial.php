<?php
/**
 * Created by PhpStorm.
 * User: lgobatto
 * Date: 8/3/16
 * Time: 17:12
 */

namespace LG\Testimonials\Block\Adminhtml;


use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Testimonial
 * @package LG\Testimonials\Block\Adminhtml
 */
class Testimonial extends Container {
	/**
	 * Constructor
	 */
	protected function _construct() {
		$this->_controller = 'adminhtml';
		$this->_blockGroup = 'LG_Testimonials';
		$this->_headerText = __( 'Testimonials' );
		parent::_construct();
		$this->removeButton( 'add' );
	}
}