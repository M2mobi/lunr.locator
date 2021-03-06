<?php

/**
 * This file contains the ConfigServiceLocatorTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\ConfigServiceLocator;
use Lunr\Core\Configuration;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the locator class.
 *
 * @covers     \Lunr\Core\ConfigServiceLocator
 */
abstract class ConfigServiceLocatorTest extends LunrBaseTest
{

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->class      = new ConfigServiceLocator($this->configuration);
        $this->reflection = new ReflectionClass('Lunr\Core\ConfigServiceLocator');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        //unset doesn't call __destruct() for some reason
        $this->class->__destruct();
        unset($this->class);
        unset($this->reflection);
        unset($this->configuration);
    }

    /**
     * Unit test data provider for invalid recipe ids.
     *
     * @return array $ids Array of invalid recipe ids.
     */
    public function invalidRecipeProvider(): array
    {
        $ids   = [];
        $ids[] = [ 'nonexisting' ];
        $ids[] = [ 'recipeidnotset' ];
        $ids[] = [ 'recipeidnotarray' ];
        $ids[] = [ 'recipeidparamsnotarray' ];

        return $ids;
    }

    /**
     * Unit test data provider for non-objects.
     *
     * @return array $values Array of non-object values
     */
    public function invalidObjectProvider(): array
    {
        $values   = [];
        $values[] = [ 'String' ];
        $values[] = [ 1 ];
        $values[] = [ 1.1 ];
        $values[] = [ NULL ];
        $values[] = [ TRUE ];

        return $values;
    }

}

?>
