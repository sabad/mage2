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
 * @package     Mage_User
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @group module:Mage_User
 */
class Mage_User_Helper_DataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Backend_Helper_Data
     */
    protected $_helper;

    protected function setUp()
    {
        parent::setUp();
        $this->_helper = Mage::helper('Mage_User_Helper_Data');
    }

    protected function tearDown()
    {
        $this->_helper = null;
    }

    /**
     * Test generate unique token for reset password confirmation link
     *
     * @covers Mage_User_Helper_Data::generateResetPasswordLinkToken
     */
    public function testGenerateResetPasswordLinkToken()
    {
        $actual = $this->_helper->generateResetPasswordLinkToken();
        $this->assertGreaterThan(15, strlen($actual));
    }

    /**
     * Test retrieve customer reset password link expiration period in days
     *
     */
    public function testGetResetPasswordLinkExpirationPeriod()
    {
        $this->assertEquals(
            1,
            (int) Mage::getConfig()->getNode(
                Mage_User_Helper_Data::XML_PATH_ADMIN_RESET_PASSWORD_LINK_EXPIRATION_PERIOD
            )
        );
    }
}
