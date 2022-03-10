<?php

/**
 * This file contains the ConfigServiceLocatorGetInstanceTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the locator class.
 *
 * @covers     Lunr\Core\ConfigServiceLocator
 */
class ConfigServiceLocatorGetInstanceTest extends ConfigServiceLocatorTest
{

    /**
     * Test that get_instance() returns NULL for a non-instantiable class.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsNullForNonInstantiableClass(): void
    {
        $cache = [ 'controller' => [ 'name' => 'LunrTest\Corona\Controller' ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertNull($method->invokeArgs($this->class, [ 'controller' ]));
    }

    /**
     * Test that get_instance() returns an instance if the class doesn't have a Constructor.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsInstanceForClassWithoutConstructor(): void
    {
        $cache = [ 'stdclass' => [ 'name' => 'stdClass' ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertInstanceOf('stdClass', $method->invokeArgs($this->class, [ 'stdclass' ]));
    }

    /**
     * Test that get_instance() returns NULL when there are not enough arguments for the Constructor.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsNullForTooLittleNumberOfConstructorArguments(): void
    {
        $cache = [ 'request' => [ 'name' => 'LunrTest\Corona\Request', 'params' => [] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertNull($method->invokeArgs($this->class, [ 'request' ]));
    }

    /**
     * Test that get_instance() returns an instance for a Constructor with arguments.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsInstanceForConstructorWithArguments(): void
    {
        $cache = [ 'datetime' => [ 'name' => 'LunrTest\Core\DateTime', 'params' => [ 'config' ] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertInstanceOf('LunrTest\Core\DateTime', $method->invokeArgs($this->class, [ 'datetime' ]));
    }

    /**
     * Test that get_instance() returns an instance for a Constructor without arguments.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsInstanceForConstructorWithoutArguments(): void
    {
        $cache = [ 'datetime' => [ 'name' => 'LunrTest\Core\DateTime', 'params' => [] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertInstanceOf('LunrTest\Core\DateTime', $method->invokeArgs($this->class, [ 'datetime' ]));
    }

    /**
     * Test that get_parameters processes ID parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesIDParameter(): void
    {
        $params = [ 'config' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertIsArray($return);
        $this->assertInstanceOf('Lunr\Core\Configuration', $return[0]);
    }

    /**
     * Test that get_parameters processes non-ID parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesNonIDParameter(): void
    {
        $params = [ 'string' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertIsArray($return);
        $this->assertEquals('string', $return[0]);
    }

    /**
     * Test that get_parameters processes non-string parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesNonStringParameter(): void
    {
        $params = [ [], 5, NULL ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertIsArray($return);
        $this->assertSame([], $return[0]);
        $this->assertSame(5, $return[1]);
        $this->assertSame(NULL, $return[2]);
    }

    /**
     * Test that get_parameters processes forced non-ID parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesForcedNonIDParameter(): void
    {
        $params = [ '!string' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertIsArray($return);
        $this->assertEquals('string', $return[0]);
    }

    /**
     * Test that get_parameters processes mixed parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesMixedParameters(): void
    {
        $params = [ 'config', '!config', 'string' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertIsArray($return);
        $this->assertInstanceOf('Lunr\Core\Configuration', $return[0]);
        $this->assertEquals('config', $return[1]);
        $this->assertEquals('string', $return[2]);
    }

}

?>
