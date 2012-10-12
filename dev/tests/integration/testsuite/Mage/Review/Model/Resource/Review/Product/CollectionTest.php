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
 * @package     Mage_Review
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Review_Model_Resource_Review_Product_CollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getResultingIds
     * 1) check that filter was applied
     * 2) check that elements are ordered correctly
     *
     * @magentoDataFixture Mage/Review/_files/different_reviews.php
     */
    public function testGetResultingIds()
    {
        $collection = new Mage_Review_Model_Resource_Review_Product_Collection();
        $collection->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
            ->setOrder('rdt.title', Mage_Review_Model_Resource_Review_Product_Collection::SORT_ORDER_ASC);
        $actual = $collection->getResultingIds();
        $this->assertCount(2, $actual);
        $this->assertLessThan($actual[0], $actual[1]);
    }
}
