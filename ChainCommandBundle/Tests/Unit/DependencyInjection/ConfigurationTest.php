<?php
/**
 * Created by IntelliJ IDEA.
 * User: nick
 * Date: 06.04.16
 * Time: 12:07
 */

namespace ChainCommandBundle\Tests\Unit\DependencyInjection;

use ChainCommandBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase {

    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $builder = $configuration->getConfigTreeBuilder();

        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $builder);
    }


}
