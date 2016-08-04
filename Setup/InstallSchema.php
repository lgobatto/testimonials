<?php
namespace LG\Testimonials\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {
	/**
	 * Function install
	 *
	 * @param SchemaSetupInterface $setup
	 * @param ModuleContextInterface $context
	 *
	 * @return void
	 */
	public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;
		$installer->startSetup();
		$table = $installer->getConnection()
		                   ->newTable( $installer->getTable( 'lg_testimonials' ) )
		                   ->addColumn(
			                   'testimonial_id',
			                   \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			                   null,
			                   [
				                   'identity' => true,
				                   'unsigned' => true,
				                   'nullable' => false,
				                   'primary'
				                              => true
			                   ],
			                   'Testimonial Id'
		                   )
		                   ->addColumn(
			                   'customer_id',
			                   \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			                   null,
			                   [ 'unsigned' => true ],
			                   'Customer Id'
		                   )
		                   ->addColumn(
			                   'testimony',
			                   \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			                   null,
			                   [ 'nullable' => false ],
			                   'Testimony'
		                   )
		                   ->addColumn(
			                   'created_at',
			                   \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			                   null,
			                   [ 'nullable' => false ],
			                   'Created At'
		                   )
		                   ->addColumn(
			                   'status',
			                   \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
			                   null,
			                   [ 'nullable' => false ],
			                   'Status'
		                   )
		                   ->addIndex(
			                   $installer->getIdxName( 'lg_testimonials', [ 'customer_id' ] ),
			                   [ 'customer_id' ]
		                   )
		                   ->addForeignKey(
			                   $installer->getFkName( 'lg_testimonials', 'customer_id',
				                   'customer_entity', 'entity_id' ),
			                   'customer_id',
			                   $installer->getTable( 'customer_entity' ),
			                   'entity_id',
			                   \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
		                   )
		                   ->setComment( 'LG Testimonials' );
		$installer->getConnection()->createTable( $table );
		$installer->endSetup();
	}
}
