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

/**
 * Menu builder command
 */
abstract class Mage_Backend_Model_Menu_Builder_CommandAbstract
{
    /**
     * List of required params
     *
     * @var array
     */
    protected $_requiredParams = array("id");

    /**
     * Command params array
     *
     * @var array
     */
    protected $_data = array();

    /**
     * Next command in the chain
     *
     * @var Mage_Backend_Model_Menu_Builder_CommandAbstract
     */
    protected $_next = null;

    /**
     * @param array $data
     * @throws InvalidArgumentException
     */
    public function __construct(array $data = array())
    {
        foreach ($this->_requiredParams as $param) {
            if (!isset($data[$param]) || is_null($data[$param])) {
                throw new InvalidArgumentException("Missing required param " . $param);
            }
        }
        $this->_data = $data;
    }

    /**
     * Retreive id of element to apply command to
     *
     * @return int
     */
    public function getId()
    {
        return $this->_data['id'];
    }

    /**
     * Add command as last in the list of callbacks
     *
     * @param Mage_Backend_Model_Menu_Builder_CommandAbstract $command
     * @return Mage_Backend_Model_Menu_Builder_CommandAbstract
     * @throws InvalidArgumentException if invalid chaining command is supplied
     */
    public function chain(Mage_Backend_Model_Menu_Builder_CommandAbstract $command)
    {
        if (is_null($this->_next)) {
            $this->_next = $command;
        } else {
            $this->_next->chain($command);
        }
        return $this;
    }

    /**
     * Execute command and pass control to chained commands
     *
     * @param array $itemParams
     * @return array
     */
    public function execute(array $itemParams = array())
    {
        $itemParams = $this->_execute($itemParams);
        if (!is_null($this->_next)) {
            $itemParams = $this->_next->execute($itemParams);
        }
        return $itemParams;
    }

    /**
     * Execute internal command actions
     *
     * @param array $itemParams
     * @return array
     */
    protected abstract function _execute(array $itemParams);
}
