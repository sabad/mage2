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
 * @package     Phoenix_Moneybookers
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Phoenix_Moneybookers_Block_PaymentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $_localeCode;

    protected function setUp()
    {
        $this->_localeCode = Mage::app()->getLocale()->getLocale();
    }

    protected function tearDown()
    {
        Mage::app()->getLocale()->setLocale($this->_localeCode);
    }

    /**
     * @dataProvider getMoneybookersLogoSrcDataProvider
     */
    public function testGetMoneybookersLogoSrc($localeCode, $expectedFile)
    {
        Mage::app()->getLocale()->setLocale($localeCode);
        /** @var $blockFactory Mage_Core_Model_BlockFactory */
        $blockFactory = Mage::getObjectManager()->get('Mage_Core_Model_BlockFactory');
        $block = $blockFactory->createBlock('Phoenix_Moneybookers_Block_Payment');
        $this->assertStringEndsWith($expectedFile, $block->getMoneybookersLogoSrc());
    }

    /**
     * @return array
     */
    public function getMoneybookersLogoSrcDataProvider()
    {
        return array(
            array('en_US', 'banner_120_int.gif'),
            array('de_DE', 'banner_120_de.png'),
            array('br_PT', 'banner_120_int.gif'),
        );
    }
}
