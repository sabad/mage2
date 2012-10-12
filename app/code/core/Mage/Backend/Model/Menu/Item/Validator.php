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
 * @package     Mage_Backend
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Mage_Backend_Model_Menu_Item_Validator
{
    /**
     * The list of required params
     *
     * @var array
     */
    protected $_required = array(
        'acl', 'appConfig', 'menuFactory', 'urlModel', 'storeConfig', 'id', 'title', 'module', 'resource'
    );

    /**
     * The list of required param types
     *
     * @var array
     */
    protected $_requiredTypes = array(
        'acl' => 'Mage_Core_Model_Authorization',
        'appConfig' => 'Mage_Core_Model_Config',
        'menuFactory' => 'Mage_Backend_Model_Menu_Factory',
        'urlModel' => 'Mage_Backend_Model_Url',
        'storeConfig' => 'Mage_Core_Model_Store_Config',
        'module' => 'Mage_Core_Helper_Abstract'
    );

    /**
     * List of created item ids
     *
     * @var array
     */
    protected $_ids = array();

    /**
     * The list of primitive validators
     *
     * @var Zend_Validate[]
     */
    protected $_validators = array();

    public function __construct()
    {
        $idValidator = new Zend_Validate();
        $idValidator->addValidator(new Zend_Validate_StringLength(array('min' => 3)));
        $idValidator->addValidator(new Zend_Validate_Regex('/^[A-Za-z0-9\/:_]+$/'));

        $resourceValidator = new Zend_Validate();
        $resourceValidator->addValidator(new Zend_Validate_StringLength(array('min' => 8)));
        $resourceValidator->addValidator(
            new Zend_Validate_Regex('/^[A-Z]+[a-z0-9]{1,}_[A-Z]+[A-Z0-9a-z]{1,}::[A-Za-z_0-9]{1,}$/')
        );

        $attributeValidator = new Zend_Validate();
        $attributeValidator->addValidator(new Zend_Validate_StringLength(array('min' => 3)));
        $attributeValidator->addValidator(new Zend_Validate_Regex('/^[A-Za-z0-9\/_]+$/'));

        $textValidator = new Zend_Validate_StringLength(array('min' => 3, 'max' => 50));

        $titleValidator = $tooltipValidator = $textValidator;
        $actionValidator = $moduleDepValidator = $configDepValidator = $attributeValidator;

        $this->_validators['id'] = $idValidator;
        $this->_validators['title'] = $titleValidator;
        $this->_validators['action'] = $actionValidator;
        $this->_validators['resource'] = $resourceValidator;
        $this->_validators['dependsOnModule'] = $moduleDepValidator;
        $this->_validators['dependsOnConfig'] = $configDepValidator;
        $this->_validators['toolTip'] = $tooltipValidator;
    }
    /**
     * Validate menu item params
     *
     * @param $data
     * @throws InvalidArgumentException
     * @throws BadMethodCallException
     */
    public function validate($data)
    {
        foreach ($this->_required as $param) {
            if (!isset($data[$param])) {
                throw new BadMethodCallException('Missing required param ' . $param);
            }
        }

        if (array_search($data['id'], $this->_ids) !== false) {
            throw new InvalidArgumentException('Item with id ' . $data ['id'] . ' already exists');
        }

        foreach ($data as $param => $value) {
            if (isset($this->_requiredTypes[$param]) && !($data[$param] instanceof $this->_requiredTypes[$param])) {
                throw new InvalidArgumentException(
                    'Wrong param ' . $param . ': Expected ' . $this->_requiredTypes[$param] . ', received '
                        . get_class($data[$param])
                );
            } elseif (!is_null($data[$param])
                && isset($this->_validators[$param])
                && !$this->_validators[$param]->isValid($value)
            ) {
                throw new InvalidArgumentException(
                    "Param " . $param . " doesn't pass validation: "
                        . implode('; ', $this->_validators[$param]->getMessages())
                );
            }
        }
        $this->_ids[] = $data['id'];
    }

    /**
     * Validate incoming param
     *
     * @param string $param
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    public function validateParam($param, $value)
    {
        if (in_array($param, $this->_required) && is_null($value)) {
            throw new InvalidArgumentException('Param ' . $param . ' is required');
        }

        if (!is_null($value) && isset($this->_validators[$param]) && !$this->_validators[$param]->isValid($value)) {
            throw new InvalidArgumentException(
                'Param ' . $param . ' doesn\'t pass validation: '
                    . implode('; ', $this->_validators[$param]->getMessages())
            );
        }
    }
}
