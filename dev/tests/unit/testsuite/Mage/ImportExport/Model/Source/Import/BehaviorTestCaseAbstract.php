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
 * @package     Mage_ImportExport
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Abstract class for behavior tests
 */
abstract class Mage_ImportExport_Model_Source_Import_BehaviorTestCaseAbstract extends PHPUnit_Framework_TestCase
{
    /**
     * Model for testing
     *
     * @var Mage_ImportExport_Model_Source_Import_BehaviorAbstract
     */
    protected $_model;

    /**
     * Helper mocks
     *
     * @var array
     */
    protected $_helpers;

    public function setUp()
    {
        $dataHelper = $this->getMock('stdClass', array('__'));
        $dataHelper->expects($this->any())
            ->method('__')
            ->will($this->returnArgument(0));
        $this->_helpers = array('Mage_ImportExport_Helper_Data' => $dataHelper);
    }

    public function tearDown()
    {
        unset($this->_model);
    }
}
