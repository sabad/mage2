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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Abstract config form element renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_System_Config_Form_Field
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Retrieve element HTML markup
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $element->getElementHtml();
    }

    /**
     * Retrieve HTML markup for given form element
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $htmlId = $element->getHtmlId();
        $isCheckboxRequired = $this->_isInheritCheckboxRequired($element);

        // Disable element if value is inherited from other scope. Flag has to be set before the value is rendered.
        if ($element->getInherit() == 1 && $isCheckboxRequired) {
            $element->setDisabled(true);
        }

        $html = '<tr id="row_' . $htmlId . '">';
        $html .= '<td class="label"><label for="' . $htmlId . '">' . $element->getLabel() . '</label></td>';
        $html .= $this->_renderValue($element);

        if ($isCheckboxRequired) {
            $html .= $this->_renderInheritCheckbox($element);
        }

        $html .= $this->_renderScopeLabel($element);
        $html .= $this->_renderHint($element);

        $html .= '</tr>';
        return $html;
    }

    /**
     * Render element value
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _renderValue(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<td class="value">';
        $html .= $this->_getElementHtml($element);
        if ($element->getComment()) {
            $html .= '<p class="note"><span>' . $element->getComment() . '</span></p>';
        }
        $html .= '</td>';
        return $html;
    }

    /**
     * Render inheritance checkbox (Use Default or Use Website)
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _renderInheritCheckbox(Varien_Data_Form_Element_Abstract $element)
    {
        $htmlId = $element->getHtmlId();
        $namePrefix = preg_replace('#\[value\](\[\])?$#', '', $element->getName());
        $checkedHtml = ($element->getInherit() == 1) ? 'checked="checked"' : '';

        $html = '<td class="use-default">';
        $html .= '<input id="' . $htmlId . '_inherit" name="' . $namePrefix . '[inherit]" type="checkbox" value="1"'
            . ' class="checkbox config-inherit" ' . $checkedHtml
            . ' onclick="toggleValueElements(this, Element.previous(this.parentNode))" /> ';
        $html .= '<label for="' . $htmlId . '_inherit" class="inherit">' . $this->_getInheritCheckboxLabel($element)
            . '</label>';
        $html .= '</td>';

        return $html;
    }

    /**
     * Check if inheritance checkbox has to be rendered
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return bool
     */
    protected function _isInheritCheckboxRequired(Varien_Data_Form_Element_Abstract $element)
    {
        return $element->getCanUseWebsiteValue() || $element->getCanUseDefaultValue();
    }

    /**
     * Retrieve label for the inheritance checkbox
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getInheritCheckboxLabel(Varien_Data_Form_Element_Abstract $element)
    {
        $checkboxLabel = Mage::helper('Mage_Adminhtml_Helper_Data')->__('Use Default');
        if ($element->getCanUseWebsiteValue()) {
            $checkboxLabel = Mage::helper('Mage_Adminhtml_Helper_Data')->__('Use Website');
        }
        return $checkboxLabel;
    }

    /**
     * Render scope label
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return Mage_Adminhtml_Block_System_Config_Form_Field
     */
    protected function _renderScopeLabel(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<td class="scope-label">';
        if ($element->getScope() && !Mage::app()->isSingleStoreMode()) {
            $html .= $element->getScopeLabel();
        }
        $html .= '</td>';
        return $html;
    }

    /**
     * Render field hint
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _renderHint(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<td class="">';
        if ($element->getHint()) {
            $html .= '<div class="hint"><div style="display: none;">' . $element->getHint() . '</div></div>';
        }
        $html .= '</td>';
        return $html;
    }

}
