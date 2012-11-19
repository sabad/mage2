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
 * @package     Mage_Backend
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Magento_Acl_Config_ReaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Magento_Acl_Config_Reader
     */
    protected $_model;

    public function setUp()
    {
        $files = array(
            realpath(__DIR__) . '/../_files/acl_1.xml',
            realpath(__DIR__) . '/../_files/acl_2.xml'
        );
        $this->_model = new Magento_Acl_Config_Reader($files);
    }

    public function testReaderImplementRequiredInterface()
    {
        $this->assertInstanceOf('Magento_Acl_Config_ReaderInterface', $this->_model);
    }

    public function testGetAclResources()
    {
        /** @var $resources DOMDocument */
        $resources = $this->_model->getAclResources();
        $this->assertNotEmpty($resources);
        $this->assertInstanceOf('DOMDocument', $resources);
    }

    public function testGetAclResourcesMergedCorrectly()
    {
        $expectedFile = realpath(__DIR__) . '/../_files/acl_merged.xml';
        $expectedResources = new DOMDocument();
        $expectedResources->load($expectedFile);

        $actualResources = $this->_model->getAclResources();

        $this->assertNotEmpty($actualResources);
        $this->assertEqualXMLStructure($expectedResources->documentElement, $actualResources->documentElement, true);
        $this->assertEquals($expectedResources, $actualResources);
    }
}
