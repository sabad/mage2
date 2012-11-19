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
 * @category    tests
 * @package     static
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * JSHint static code analysis tests for javascript files
 */
class Js_LiveCodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected static $_reportFile = '';

    /**
     * @var array
     */
    protected static $_whiteListJsFiles = array();

    /**
     * @var array
     */
    protected static $_blackListJsFiles = array();

    /**
     * @static Return all files under a path
     * @param string $path
     * @return array
     */
    protected static function _scanJsFile($path)
    {
        if (is_file($path)) {
            return array($path);
        }
        $path = $path == '' ? dirname(__FILE__) : $path;
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $regexIterator = new RegexIterator($iterator, '/\\.js$/');
        $filePaths = array();
        foreach ($regexIterator as $filePath) {
            $filePaths[] = $filePath->getPathname();
        }
        return $filePaths;
    }

    /**
     * @static Setup report file, black list and white list
     *
     */
    public static function setUpBeforeClass()
    {
        $reportDir = Utility_Files::init()->getPathToSource() . '/dev/tests/static/report';
        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0777);
        }
        self::$_reportFile = $reportDir . '/js_report.txt';
        @unlink(self::$_reportFile);
        $whiteList = self::_readLists(__DIR__ . '/_files/whitelist/*.txt');
        $blackList = self::_readLists(__DIR__ . '/_files/blacklist/*.txt');
        foreach ($blackList as $listFiles) {
            self::$_blackListJsFiles = array_merge(self::$_blackListJsFiles, self::_scanJsFile($listFiles));
        }
        foreach ($whiteList as $listFiles) {
            self::$_whiteListJsFiles = array_merge(self::$_whiteListJsFiles, self::_scanJsFile($listFiles));
        }
        $blackListJsFiles = self::$_blackListJsFiles;
        $filter = function($value) use($blackListJsFiles)
        {
            return !in_array($value, $blackListJsFiles);
        };
        self::$_whiteListJsFiles = array_filter(self::$_whiteListJsFiles, $filter);
    }

    /**
     * @param $filename
     *
     * @throws Exception
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function _verifyTestRunnable($filename)
    {
        $command = 'which rhino';
        if ($this->_isOsWin()) {
            $command = 'cscript';
        }
        exec($command, $output, $retVal);
        if ($retVal != 0) {
            throw new Exception($command . ' does not exist.');
        }
        if (!file_exists($filename)) {
            throw new Exception($filename . ' does not exist.');
        }
    }

    /**
     * @dataProvider codeJsHintDataProvider
     */
    public function testCodeJsHint($filename)
    {
        try{
            $this->_verifyTestRunnable($filename);
        } catch (Exception $e) {
            $this->markTestSkipped($e->getMessage());
        }
        $result = $this->_executeJsHint($filename);
        if (!$result) {
            $this->fail("Failed JSHint.");
        }
    }

    /**
     * Build data provider array with command, js file name, and option
     * @return array
     */
    public function codeJsHintDataProvider()
    {
        self::setUpBeforeClass();
        $map = function($value)
        {
            return array($value);
        };
        return array_map($map, self::$_whiteListJsFiles);
    }

    /**
     * Returns cscript for windows and rhino for linux
     * @return string
     */
    protected function _getCommand()
    {
        if ($this->_isOsWin()) {
            return 'cscript ' . TESTS_JSHINT_PATH;
        } else {
            return 'rhino ' . TESTS_JSHINT_PATH;
        }
    }

    protected function _isOsWin()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Run jsHint against js file; if failed output error to report file
     * @param $filename - js file name with full path
     * @return bool
     */
    protected function _executeJsHint($filename)
    {
        exec($this->_getCommand() . ' ' . $filename . ' ' . TESTS_JSHINT_OPTIONS, $output, $retVal);
        if ($retVal == 0) {
            return true;
        }
        if ($this->_isOsWin()) {
            $output = array_slice($output, 2);
        }
        $output[] = ''; //empty line to separate each file output
        file_put_contents(self::$_reportFile, implode(PHP_EOL, $output), FILE_APPEND);
        return false;
    }

    /**
     * Read all text files by specified glob pattern and combine them into an array of valid files/directories
     *
     * The Magento root path is prepended to all (non-empty) entries
     *
     * @param string $globPattern
     * @return array
     */
    protected static function _readLists($globPattern)
    {
        $result = array();
        foreach (glob($globPattern) as $list) {
            $result = array_merge($result, file($list));
        }
        $map = function($value)
        {
            return trim($value) ? Utility_Files::init()->getPathToSource() . DIRECTORY_SEPARATOR .
                str_replace('/', DIRECTORY_SEPARATOR, trim($value)) : '';
        };
        return array_filter(array_map($map, $result), 'file_exists');
    }
}