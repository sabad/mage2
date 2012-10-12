<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Mage_DesignEditor
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_DesignEditor_Model_History_CompactTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_DesignEditor_Model_History
     */
    protected $_historyObject;

    /**
     * Prepare history object
     *
     * @return Mage_Core_Model_Abstract
     */
    public function setUp()
    {
        return $this->_historyObject = Mage::getModel('Mage_DesignEditor_Model_History');
    }

    /**
     * Test compact
     *
     * @dataProvider getChanges
     */
    public function testCompact($changes, $compactResult)
    {
        /** @var $historyCompactModel Mage_DesignEditor_Model_History_Compact */
        $historyCompactModel = Mage::getModel('Mage_DesignEditor_Model_History_Compact');
        /** @var $collection Mage_DesignEditor_Model_Change_Collection */
        $collection = $this->_historyObject->setChanges($changes)->getChanges();

        $historyCompactModel->compact($collection);

        $this->assertEquals($compactResult, $collection->toArray());
    }

    /**
     * Get changes
     *
     * @return array
     */
    public function getChanges()
    {
        return array(array(
            array(
                array(
                    'handle'                => 'catalog_category_view',
                    'type'                  => 'layout',
                    'element_name'          => 'category.products',
                    'action_name'           => 'move',
                    'destination_container' => 'content',
                    'destination_order'     => '-',
                    'origin_container'      => 'top.menu',
                    'origin_order'          => '-'
                ),
                array(
                    'handle'                => 'catalog_category_view',
                    'type'                  => 'layout',
                    'element_name'          => 'category.products',
                    'action_name'           => 'move',
                    'destination_container' => 'right',
                    'destination_order'     => '-',
                    'origin_container'      => 'content',
                    'origin_order'          => '-'
                ),
                array(
                    'handle'                => 'customer_account',
                    'type'                  => 'layout',
                    'element_name'          => 'customer_account_navigation',
                    'action_name'           => 'move',
                    'destination_container' => 'content',
                    'destination_order'     => '-',
                    'origin_container'      => 'right',
                    'origin_order'          => '-'
                ),
                array(
                    'handle'                => 'customer_account',
                    'type'                  => 'layout',
                    'element_name'          => 'customer_account_navigation',
                    'action_name'           => 'remove',
                ),
                array(
                    'handle'                => 'customer_account',
                    'type'                  => 'layout',
                    'element_name'          => 'customer_account_navigation',
                    'action_name'           => 'remove',
                ),
            ),
            /** Expected result for compact */
            array(
                array(
                    'handle'                => 'catalog_category_view',
                    'type'                  => 'layout',
                    'element_name'          => 'category.products',
                    'action_name'           => 'move',
                    'destination_container' => 'right',
                    'destination_order'     => '-',
                    'origin_container'      => 'content',
                    'origin_order'          => '-'
                ),
                array(
                    'handle'                => 'customer_account',
                    'type'                  => 'layout',
                    'element_name'          => 'customer_account_navigation',
                    'action_name'           => 'remove',
                ),
            )
        ));
    }
}
