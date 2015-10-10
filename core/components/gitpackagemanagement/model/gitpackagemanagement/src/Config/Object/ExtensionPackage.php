<?php
namespace GPM\Config\Object;

use GPM\Config\ConfigObject;

class ExtensionPackage extends ConfigObject
{
    /** @var string */
    public $name;
    
    /** @var string */
    public $namespace;

    /** @var string */
    public $path;

    /** @var string */
    public $tablePrefix = 'modx_';

    /** @var string */
    public $serviceName = '';

    /** @var string */
    public $serviceClass = '';

    protected $rules = [
        'name' => 'notEmpty',
        'namespace' => 'notEmpty',
        'path' => 'notEmpty',
        'serviceName' => 'notEmptyWith:serviceClass',
        'serviceClass' => 'notEmptyWith:serviceName',
    ];
    
    public function toArray()
    {
        // @TODO
        return [];
    }
    
    protected function setDefaults($config)
    {
        if (empty($config['namespace'])) {
            $this->namespace = $this->config->general->lowCaseName;
        }
        
        if (empty($config['name'])) {
            $this->name = $this->config->general->lowCaseName;
        }
        
        if (empty($config['path'])) {
            $this->path = $this->config->general->corePath;
        }
    }
}