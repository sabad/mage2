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
 * @category    Tools
 * @package     unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once realpath(dirname(__FILE__) . '/../../../../../../../../') . '/tools/migration/Acl/Db/LoggerAbstract.php';
require_once realpath(dirname(__FILE__) . '/../../../../../../../../') . '/tools/migration/Acl/Db/Logger/File.php';

class Tools_Migration_Acl_Db_Logger_FileTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithValidFile()
    {
        new Tools_Migration_Acl_Db_Logger_File(realpath(dirname(__FILE__) . '/../../../../../') . '/tmp/');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructWithInValidFile()
    {
        new Tools_Migration_Acl_Db_Logger_File(null);
    }
}

