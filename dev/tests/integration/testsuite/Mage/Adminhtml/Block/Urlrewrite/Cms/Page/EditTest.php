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
 * Test for Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit
 */
class Mage_Adminhtml_Block_Urlrewrite_Cms_Page_EditTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test prepare layout
     *
     * @dataProvider prepareLayoutDataProvider
     *
     * @param array $blockAttributes
     * @param array $expected
     */
    public function testPrepareLayout($blockAttributes, $expected)
    {
        $layout = new Mage_Core_Model_Layout(array('area' => Mage_Core_Model_App_Area::AREA_ADMINHTML));

        /** @var $block Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit */
        $block = $layout->createBlock('Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit', '', $blockAttributes);

        $this->_checkSelector($block, $expected);
        $this->_checkLinks($block, $expected);
        $this->_checkButtons($block, $expected);
        $this->_checkForm($block, $expected);
        $this->_checkGrid($block, $expected);
    }

    /**
     * Check selector
     *
     * @param Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit $block
     * @param array $expected
     */
    private function _checkSelector($block, $expected)
    {
        $layout = $block->getLayout();
        $blockName = $block->getNameInLayout();

        /** @var $selectorBlock Mage_Adminhtml_Block_Urlrewrite_Selector|bool */
        $selectorBlock = $layout->getChildBlock($blockName, 'selector');

        if ($expected['selector']) {
            $this->assertInstanceOf('Mage_Adminhtml_Block_Urlrewrite_Selector', $selectorBlock,
                'Child block with entity selector is invalid');
        } else {
            $this->assertFalse($selectorBlock, 'Child block with entity selector should not present in block');
        }
    }

    /**
     * Check links
     *
     * @param Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit $block
     * @param array $expected
     */
    private function _checkLinks($block, $expected)
    {
        $layout = $block->getLayout();
        $blockName = $block->getNameInLayout();

        /** @var $cmsPageLinkBlock Mage_Adminhtml_Block_Urlrewrite_Link|bool */
        $cmsPageLinkBlock = $layout->getChildBlock($blockName, 'cms_page_link');

        if ($expected['cms_page_link']) {
            $this->assertInstanceOf('Mage_Adminhtml_Block_Urlrewrite_Link', $cmsPageLinkBlock,
                'Child block with CMS page link is invalid');

            $this->assertEquals('CMS page:', $cmsPageLinkBlock->getLabel(),
                'Child block with CMS page has invalid item label');

            $this->assertEquals($expected['cms_page_link']['name'], $cmsPageLinkBlock->getItemName(),
                'Child block with CMS page has invalid item name');

            $this->assertRegExp('/http:\/\/localhost\/index.php\/.*\/cms_page/', $cmsPageLinkBlock->getItemUrl(),
                'Child block with CMS page contains invalid URL');
        } else {
            $this->assertFalse($cmsPageLinkBlock, 'Child block with CMS page link should not present in block');
        }
    }

    /**
     * Check buttons
     *
     * @param Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit $block
     * @param array $expected
     */
    private function _checkButtons($block, $expected)
    {
        $buttonsHtml = $block->getButtonsHtml();

        if ($expected['back_button']) {
            if ($block->getCmsPage()->getId()) {
                $this->assertSelectCount('button.back[onclick~="\/cms_page"]', 1, $buttonsHtml,
                    'Back button is not present in CMS page URL rewrite edit block');
            } else {
                $this->assertSelectCount('button.back', 1, $buttonsHtml,
                    'Back button is not present in CMS page URL rewrite edit block');
            }
        } else {
            $this->assertSelectCount('button.back', 0, $buttonsHtml,
                'Back button should not present in CMS page URL rewrite edit block');
        }

        if ($expected['save_button']) {
            $this->assertSelectCount('button.save', 1, $buttonsHtml,
                'Save button is not present in CMS page URL rewrite edit block');
        } else {
            $this->assertSelectCount('button.save', 0, $buttonsHtml,
                'Save button should not present in CMS page URL rewrite edit block');
        }

        if ($expected['reset_button']) {
            $this->assertSelectCount('button[title="Reset"]', 1, $buttonsHtml,
                'Reset button is not present in CMS page URL rewrite edit block');
        } else {
            $this->assertSelectCount('button[title="Reset"]', 0, $buttonsHtml,
                'Reset button should not present in CMS page URL rewrite edit block');
        }

        if ($expected['delete_button']) {
            $this->assertSelectCount('button.delete', 1, $buttonsHtml,
                'Delete button is not present in CMS page URL rewrite edit block');
        } else {
            $this->assertSelectCount('button.delete', 0, $buttonsHtml,
                'Delete button should not present in CMS page URL rewrite edit block');
        }
    }

    /**
     * Check form
     *
     * @param Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit $block
     * @param array $expected
     */
    private function _checkForm($block, $expected)
    {
        $layout = $block->getLayout();
        $blockName = $block->getNameInLayout();

        /** @var $formBlock Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit_Form|bool */
        $formBlock = $layout->getChildBlock($blockName, 'form');

        if ($expected['form']) {
            $this->assertInstanceOf('Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit_Form', $formBlock,
                'Child block with form is invalid');

            $this->assertSame($expected['form']['cms_page'], $formBlock->getCmsPage(),
                'Form block should have same CMS page attribute');

            $this->assertSame($expected['form']['url_rewrite'], $formBlock->getUrlRewrite(),
                'Form block should have same URL rewrite attribute');
        } else {
            $this->assertFalse($formBlock, 'Child block with form should not present in block');
        }
    }

    /**
     * Check grid
     *
     * @param Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Edit $block
     * @param array $expected
     */
    private function _checkGrid($block, $expected)
    {
        $layout = $block->getLayout();
        $blockName = $block->getNameInLayout();

        /** @var $gridBlock Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Grid|bool */
        $gridBlock = $layout->getChildBlock($blockName, 'cms_pages_grid');

        if ($expected['cms_pages_grid']) {
            $this->assertInstanceOf('Mage_Adminhtml_Block_Urlrewrite_Cms_Page_Grid', $gridBlock,
                'Child block with CMS pages grid is invalid');
        } else {
            $this->assertFalse($gridBlock, 'Child block with CMS pages grid should not present in block');
        }
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function prepareLayoutDataProvider()
    {
        $urlRewrite = new Mage_Core_Model_Url_Rewrite();
        $cmsPage = new Mage_Cms_Model_Page(array(
            'page_id' => 1,
            'title' => 'Test CMS Page'
        ));
        $existingUrlRewrite = new Mage_Core_Model_Url_Rewrite(array(
            'url_rewrite_id' => 1,
        ));

        return array(
            // Creating URL rewrite when CMS page selected
            array(
                array(
                    'cms_page' => $cmsPage,
                    'url_rewrite' => $urlRewrite
                ),
                array(
                    'selector' => false,
                    'cms_page_link' => array(
                        'name' => $cmsPage->getTitle()
                    ),
                    'back_button' => true,
                    'save_button' => true,
                    'reset_button' => false,
                    'delete_button' => false,
                    'form' => array(
                        'cms_page' => $cmsPage,
                        'url_rewrite' => $urlRewrite
                    ),
                    'cms_pages_grid' => false
                )
            ),
            // Creating URL rewrite when CMS page not selected
            array(
                array(
                    'url_rewrite' => $urlRewrite
                ),
                array(
                    'selector' => true,
                    'cms_page_link' => false,
                    'back_button' => true,
                    'save_button' => false,
                    'reset_button' => false,
                    'delete_button' => false,
                    'form' => false,
                    'cms_pages_grid' => true
                )
            ),
            // Editing existing URL rewrite with CMS page
            array(
                array(
                    'url_rewrite' => $existingUrlRewrite,
                    'cms_page' => $cmsPage
                ),
                array(
                    'selector' => false,
                    'cms_page_link' => array(
                        'name' => $cmsPage->getTitle(),
                    ),
                    'back_button' => true,
                    'save_button' => true,
                    'reset_button' => true,
                    'delete_button' => true,
                    'form' => array(
                        'cms_page' => $cmsPage,
                        'url_rewrite' => $existingUrlRewrite
                    ),
                    'cms_pages_grid' => false
                )
            ),
        );
    }
}
