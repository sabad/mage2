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
 * @package     performance_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Bootstrap for performance tests
 */
class Magento_Performance_Bootstrap
{
    /**
     * Tests configuration holder
     *
     * @var Magento_Performance_Config
     */
    protected $_config;

    /**
     * Constructor
     *
     * @param string $testsBaseDir
     * @param string $appBaseDir
     */
    public function __construct($testsBaseDir, $appBaseDir)
    {
        $configFile = "$testsBaseDir/config.php";
        $configFile = file_exists($configFile) ? $configFile : "$configFile.dist";
        $configData = require $configFile;
        $this->_config = new Magento_Performance_Config($configData, $testsBaseDir, $appBaseDir);
    }

    /**
     * Ensure reports directory exists, empty, and has write permissions
     *
     * @throws Magento_Exception
     */
    public function cleanupReports()
    {
        $reportDir = $this->_config->getReportDir();
        if (file_exists($reportDir) && !Varien_Io_File::rmdirRecursive($reportDir)) {
            throw new Magento_Exception("Cannot cleanup reports directory '$reportDir'.");
        }
        mkdir($reportDir, 0777);
    }

    /**
     * Return configuration for the tests
     *
     * @return Magento_Performance_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }
}
