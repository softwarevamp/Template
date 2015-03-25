<?php

namespace PHPixie\Tests\Template;

/**
 * @coversDefaultClass \PHPixie\Template\Resolver
 */
class ResolverTest extends \PHPixie\Test\Testcase
{
    protected $locators;
    protected $compiler;
    protected $configData;
    
    protected $resolver;
    
    protected $locator;
    protected $overrides = array(
        'pixie' => 'fairy'
    );
    
    public function setUp()
    {
        $this->locators  = $this->quickMock('\PHPixie\Template\Locators');
        $this->compiler = $this->quickMock('\PHPixie\Template\Compiler');
        $this->configData = $this->getData();
        
        $locatorConfig = $this->getData();
        $this->method($this->configData, 'slice', $locatorConfig, array('locator'), 0);
        
        $this->locator = $this->abstractMock('\PHPixie\Template\Locators\Locator');
        $this->method($this->locators, 'buildFromConfig', $this->locator, array($locatorConfig), 0);
        
        $this->method($this->configData, 'get', $this->overrides, array('overrides', array()), 1);
        
        $this->resolver = new \PHPixie\Template\Resolver(
            $this->locators,
            $this->compiler,
            $this->configData
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::resolve
     * @covers ::<protected>
     */
    public function testResolve()
    {
        $file = 'fairy.php';
        $compiledFile = 'trixie.php';
        
        $templateMap = array(
            'trixie' => 'trixie',
            'pixie'  => 'fairy'
        );
        
        foreach($templateMap as $template => $override) {
            $this->method($this->locator, 'getTemplateFile', $file, array($override), 0);
            $this->method($this->compiler, 'compile', $compiledFile, array($file), 0);
            
            $this->assertSame($compiledFile, $this->resolver->resolve($template));
            $this->assertSame($compiledFile, $this->resolver->resolve($template));
        }
        
        $this->method($this->locator, 'getTemplateFile', null, array('blum'), 0);
        $resolver = $this->resolver;
        $this->assertException(function() use($resolver){
            $resolver->resolve('blum');
        }, '\PHPixie\Template\Exception');
    }
    
    protected function getData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
}