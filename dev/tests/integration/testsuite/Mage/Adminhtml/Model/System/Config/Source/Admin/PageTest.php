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
 * @package     Mage_Adminhtml
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Test Mage_Adminhtml_Model_System_Config_Source_Admin_Page
 */
class Mage_Adminhtml_Model_System_Config_Source_Admin_PageTest extends Mage_Adminhtml_Utility_Controller
{
    public function testToOptionArray()
    {
        $this->dispatch('backend/admin/system_config/edit/section/admin');

        $dom = PHPUnit_Util_XML::load($this->getResponse()->getBody(), true);
        $select = $dom->getElementById('admin_startup_menu_item_id');

        $this->assertNotEmpty($select, 'Startup Page select missed');
        $options = $select->getElementsByTagName('option');
        $optionsCount = $options->length;

        $this->assertGreaterThan(97, $optionsCount, 'Paucity count of menu items in the list');

        $this->assertEquals('Dashboard', $options->item(0)->nodeValue, 'First element is not Dashboard');
        $this->assertContains('Configuration', $options->item($optionsCount - 1)->nodeValue);
    }
}
