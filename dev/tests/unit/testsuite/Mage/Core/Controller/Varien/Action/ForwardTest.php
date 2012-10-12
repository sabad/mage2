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
 * @category    Mage
 * @package     Mage_Core
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Test class Mage_Core_Controller_Varien_Action_Forward
 */
class Mage_Core_Controller_Varien_Action_ForwardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Core_Controller_Varien_Action_Forward
     */
    protected $_object = null;

    /**
     * @var Zend_Controller_Request_Http
     */
    protected $_request;

    /**
     * @var Zend_Controller_Response_Http
     */
    protected $_response;

    protected function setUp()
    {
        $this->_request = new Zend_Controller_Request_Http();

        $this->_response = new Zend_Controller_Response_Http();

        $this->_object = new Mage_Core_Controller_Varien_Action_Forward($this->_request, $this->_response);
    }

    /**
     * Test that Mage_Core_Controller_Varien_Action_Forward::dispatch() does not change dispatched flag
     */
    public function testDispatch()
    {
        $this->_request->setDispatched(true);
        $this->assertTrue($this->_request->isDispatched());
        $this->_object->dispatch('any action');
        $this->assertFalse($this->_request->isDispatched());
    }
}
