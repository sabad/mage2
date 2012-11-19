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
 * @package     Mage_DesignEditor
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Design editor launcher form
 */
class Mage_DesignEditor_Block_Adminhtml_Launcher_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Create a form element with necessary controls
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('adminhtml/system_design_editor/launch'),
            'target'    => '_blank'
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                array('legend' => Mage::helper('Mage_DesignEditor_Helper_Data')->__('Context Information'))
            );
            $fieldset->addField('store_id', 'select', array(
                'name'      => 'store_id',
                'label'     => Mage::helper('Mage_DesignEditor_Helper_Data')->__('Store View'),
                'title'     => Mage::helper('Mage_DesignEditor_Helper_Data')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('Mage_Core_Model_System_Store')->getStoreValuesForForm(),
            ));
        }

        $form->addField('theme_id', 'hidden', array(
            'name' => 'theme_id'
        ));
        $form->addField('theme_skin', 'hidden', array(
           'name' => 'theme_skin'
        ));

        $this->setForm($form);
        $form->setUseContainer(true);

        return parent::_prepareForm();
    }
}
