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
 * @package     Magento_Catalog
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Catalog_Helper_Product_FlatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Catalog_Helper_Product_Flat
     */
    protected $_helper;

    protected function setUp()
    {
        $this->_helper = Mage::helper('Mage_Catalog_Helper_Product_Flat');
    }

    protected function tearDown()
    {
        $this->_helper = null;
    }

    public function testGetFlag()
    {
        $flag = $this->_helper->getFlag();
        $this->assertInstanceOf('Mage_Catalog_Model_Product_Flat_Flag', $flag);
    }

    public function testIsBuilt()
    {
        $this->assertFalse($this->_helper->isBuilt());
        $flag = $this->_helper->getFlag();
        try {
            $flag->setIsBuilt(true);
            $this->assertTrue($this->_helper->isBuilt());

            $flag->setIsBuilt(false);
        } catch (Exception $e) {
            $flag->setIsBuilt(false);
            throw $e;
        }
    }

    public function testIsEnabledDefault()
    {

        $this->assertFalse($this->_helper->isEnabled());
    }

    /**
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_product 1
     */
    public function testIsEnabled()
    {
        $this->assertTrue($this->_helper->isEnabled());
    }

    public function testIsAddFilterableAttributesDefault()
    {
        $this->assertEquals(0, $this->_helper->isAddFilterableAttributes());
    }

    /**
     * @magentoConfigFixture global/catalog/product/flat/add_filterable_attributes 1
     */
    public function testIsAddFilterableAttributes()
    {
        $this->assertEquals(1, $this->_helper->isAddFilterableAttributes());
    }

    public function testIsAddChildDataDefault()
    {
        $this->assertEquals(0, $this->_helper->isAddChildData());
    }

    /**
     * @magentoConfigFixture global/catalog/product/flat/add_child_data 1
     */
    public function testIsAddChildData()
    {
        $this->assertEquals(1, $this->_helper->isAddChildData());
    }
}
