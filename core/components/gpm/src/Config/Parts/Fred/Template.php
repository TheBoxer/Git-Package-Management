<?php
namespace GPM\Config\Parts\Fred;

use GPM\Config\Config;
use GPM\Config\Parts\Part;
use GPM\Config\Rules;

/**
 * Class Category
 *
 * @property-read string $name
 * @property-read string $defaultBlueprint
 *
 * @package GPM\Config\Parts\Element
 */
class Template extends Part
{
    protected $keyField = 'name';

    /** @var string */
    protected $name = '';

    protected $defaultBlueprint = '';

    protected $rules = [
        'name' => [Rules::isString, Rules::notEmpty],
        'defaultBlueprint' => [Rules::isString],
    ];

    protected function generator(): void
    {
    }

    public function setConfig(Config $config): void
    {
        parent::setConfig($config);
    }

    public function getObject()
    {
        $obj = $this->config->modx->getObject('\\Fred\\Model\\FredThemedTemplate', ['template' => $this->config->fred->getTemplateId($this->name), 'theme' => $this->config->fred->getThemeId()]);

        if ($obj === null) {
            $obj = $this->config->modx->newObject('\\Fred\\Model\\FredThemedTemplate');
            $obj->set('template', $this->config->fred->getTemplateId($this->name));
            $obj->set('theme', $this->config->fred->getThemeId());
        }

        if (!empty($this->defaultBlueprint)) {
            $obj->set('default_blueprint', $this->config->fred->getBlueprintId($this->defaultBlueprint));
        }

        return $obj;
    }

    public function deleteObject()
    {
        $obj = $this->config->modx->getObject('\\Fred\\Model\\FredThemedTemplate', ['template' => $this->config->fred->getTemplateId($this->name), 'theme' => $this->config->fred->getThemeId()]);

        if ($obj !== null) {
            $obj->remove();
        }
    }
}
