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
 * @package     Mage_Core
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Core_Block_AbstractTest extends Magento_Test_TestCase_ObjectManagerAbstract
{
    /**
     * @param string $expectedResult
     * @param string $nameInLayout
     * @param array $methodArguments
     * @dataProvider dataGetUiId
     */
    public function testGetUiId($expectedResult, $nameInLayout, $methodArguments)
    {
        /** @var $block Mage_Core_Block_Abstract */
        $block = $this->getMockForAbstractClass('Mage_Core_Block_Abstract',
            array(), '', false);
        $block->setNameInLayout($nameInLayout);

        $this->assertEquals(
            $expectedResult,
            call_user_func_array(array($block, 'getUiId'), $methodArguments)
        );
    }

    public static function dataGetUiId()
    {
        return array(
            array(' data-ui-id="" ', null, array()),
            array(' data-ui-id="block" ', 'block', array()),
            array(' data-ui-id="block" ', 'block---', array()),
            array(' data-ui-id="block" ', '--block', array()),
            array(' data-ui-id="bl-ock" ', '--bl--ock---', array()),
            array(' data-ui-id="bl-ock" ', '--bL--Ock---', array()),
            array(' data-ui-id="b-l-o-c-k" ', '--b!@#$%^&**()L--O;:...c<_>k---', array()),
            array(' data-ui-id="a0b1c2d3e4f5g6h7-i8-j9k0l1m2n-3o4p5q6r7-s8t9u0v1w2z3y4x5" ',
                'a0b1c2d3e4f5g6h7', array('i8-j9k0l1m2n-3o4p5q6r7', 's8t9u0v1w2z3y4x5')
            ),
            array(' data-ui-id="capsed-block-name-cap-ed-param1-caps2-but-ton" ',
                'CaPSed BLOCK NAME', array('cAp$Ed PaRaM1', 'caPs2', 'bUT-TOn')
            ),
            array(' data-ui-id="block-0-1-2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20" ',
                '!block!', range(0, 20)
            ),
        );
    }
}
