<?php

namespace Test\Downloadable\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable('downloadable_link'),
            'is_visible',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length' => 5,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Is Visible'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('downloadable_link_purchased_item'),
            'is_visible',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length' => 5,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Is Visible'
            ]
        );

        $installer->endSetup();
    }
}
