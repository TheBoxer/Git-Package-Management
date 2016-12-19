<?php

class GitPackageConfigAction {
    private $modx;
    /* @var $gitPackageConfig GitPackageConfig */
    private $gitPackageConfig;
    private $id;
    private $controller;
    private $hasLayout;
    private $langTopics;
    private $assets;
    private $namespace;

    public function __construct(modX &$modx, $gitPackageConfig) {
        $this->modx =& $modx;
        $this->gitPackageConfig = $gitPackageConfig;
    }

    public function fromArray($config) {
        if(isset($config['id'])){
            $this->id = $config['id'];
        }else{
            $this->gitPackageConfig->error->addError('Actions - id is not set', true);
            return false;
        }

        if(isset($config['controller'])){
            $this->controller = $config['controller'];
        }else{
            $this->gitPackageConfig->error->addError('Actions - controller is not set', true);
            return false;
        }

        if(isset($config['hasLayout'])){
            $this->hasLayout = $config['hasLayout'];
        }else{
            $this->hasLayout = 1;
        }

        if(isset($config['langTopics'])){
            $this->langTopics = $config['langTopics'];
        }else{
            $this->langTopics = $this->gitPackageConfig->getLowCaseName().':default';
        }

        if(isset($config['assets'])){
            $this->assets = $config['assets'];
        }else{
            $this->assets = '';
        }

        if(!empty($config['namespace'])){
            $this->namespace = $config['namespace'];
        }else{
            $this->namespace = $this->gitPackageConfig->getLowCaseName();
        }

        return true;
    }

    public function getAssets() {
        return $this->assets;
    }

    public function getController() {
        return $this->controller;
    }

    public function getHasLayout() {
        return $this->hasLayout;
    }

    public function getId() {
        return $this->id;
    }

    public function getLangTopics() {
        return $this->langTopics;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }
}