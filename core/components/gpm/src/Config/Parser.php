<?php
namespace GPM\Config;

use Symfony\Component\Yaml\Yaml;

class Parser
{
    /** @var array */
    private $config;

    private $packageDir;

    public function __construct($packageDir)
    {
        $this->packageDir = $packageDir;
        $configFile = $packageDir . '_build' . DIRECTORY_SEPARATOR . 'gpm';

        if (file_exists($configFile . '.json')) {
            $this->config = $this->parseJSON(file_get_contents($configFile . '.json'));
            return;
        }

        if (file_exists($configFile . '.yml')) {
            $this->config = $this->parseYAML(file_get_contents($configFile . '.yml'));
            return;
        }

        if (file_exists($configFile . '.yaml')) {
            $this->config = $this->parseYAML(file_get_contents($configFile . '.yaml'));
            return;
        }

        throw new \Exception('Config file not found. Please create gpm.yml under _build folder.');
    }


    public function parse(): array
    {
        if (empty($this->config)) return [];

        return [
            'paths' => $this->getPaths(),
            'general' => $this->getGeneral(),
            'systemSettings' => $this->getSystemSettings(),
            'menus' => $this->getMenus(),
            'database' => $this->getDatabase(),
            'snippets' => $this->getSnippets(),
            'chunks' => $this->getChunks(),
            'plugins' => $this->getPlugins(),
            'templates' => $this->getTemplates(),
            'categories' => $this->getCategories(),
            'propertySets' => $this->getPropertySets(),
            'build' => $this->getBuild(),
        ];
    }

    private function getPaths(): array
    {
        return [
            'package' => $this->packageDir
        ];
    }

    private function getGeneral(): array
    {
        return [
            'name' => $this->config['name'] ?? '',
            'lowCaseName' => $this->config['lowCaseName'] ?? '',
            'description' => $this->config['description'] ?? '',
            'author' => $this->config['author'] ?? '',
            'version' => $this->config['version'] ?? '',
            'namespace' => $this->config['namespace'] ?? '',
        ];
    }

    private function getSystemSettings(): array
    {
        $output = [];

        if (!isset($this->config['systemSettings'])) return $output;

        $systemSettings = $this->config['systemSettings'];
        if (is_string($systemSettings)) {
            die('load file');
        }

        if (!is_array($systemSettings)) return $output;

        foreach ($systemSettings as $systemSetting) {
            if (is_string($systemSetting)) {
                die('load file');
            }

            if (is_array($systemSetting)) {
                $output[] = $systemSetting;
            }
        }

        return $output;
    }

    private function getMenus(): array
    {
        $output = [];

        if (!isset($this->config['menus'])) return $output;

        $menus = $this->config['menus'];
        if (is_string($menus)) {
            die('load file');
        }

        if (!is_array($menus)) return $output;

        foreach ($menus as $menu) {
            if (is_string($menu)) {
                die('load file');
            }

            if (is_array($menu)) {
                $output[] = $menu;
            }
        }

        return $output;
    }

    private function getDatabase(): array
    {
        if (!isset($this->config['database'])) return [];

        $database = $this->config['database'];
        if (is_string($database)) {
            die('load file');
        }

        if (is_array($database)) return $database;

        return [];
    }

    private function getBuild(): array
    {
        if (!isset($this->config['build'])) return [];

        $build = $this->config['build'];
        if (is_string($build)) {
            die('load file');
        }

        if (is_array($build)) return $build;

        return [];
    }

    private function getSnippets(): array
    {
        $output = [];

        if (!isset($this->config['snippets'])) return $output;

        $snippets = $this->config['snippets'];
        if (is_string($snippets)) {
            die('load file');
        }

        if (!is_array($snippets)) return $output;

        foreach ($snippets as $snippet) {
            if (is_string($snippet)) {
                die('load file');
            }

            if (is_array($snippet)) {
                $snippet['properties'] = $this->getProperties($snippet);

                if (is_string($snippet['category'])) {
                    $snippet['category'] = [$snippet['category']];
                }

                $output[] = $snippet;
            }
        }

        return $output;
    }

    private function getChunks(): array
    {
        $output = [];

        if (!isset($this->config['chunks'])) return $output;

        $chunks = $this->config['chunks'];
        if (is_string($chunks)) {
            die('load file');
        }

        if (!is_array($chunks)) return $output;

        foreach ($chunks as $chunk) {
            if (is_string($chunk)) {
                die('load file');
                continue;
            }

            if (is_array($chunk)) {
                $chunk['properties'] = $this->getProperties($chunk);
                if (is_string($chunk['category'])) {
                    $chunk['category'] = [$chunk['category']];
                }

                $output[] = $chunk;
            }
        }

        return $output;
    }

    private function getPropertySets(): array
    {
        $output = [];

        if (!isset($this->config['propertySets'])) return $output;

        $propertySets = $this->config['propertySets'];
        if (is_string($propertySets)) {
            die('load file');
        }

        if (!is_array($propertySets)) return $output;

        foreach ($propertySets as $propertySet) {
            if (is_string($propertySet)) {
                die('load file');
                continue;
            }

            if (is_array($propertySet)) {
                $propertySet['properties'] = $this->getProperties($propertySet);
                if (is_string($propertySet['category'])) {
                    $propertySet['category'] = [$propertySet['category']];
                }

                $output[] = $propertySet;
            }
        }

        return $output;
    }

    private function getTemplates(): array
    {
        $output = [];

        if (!isset($this->config['templates'])) return $output;

        $templates = $this->config['templates'];
        if (is_string($templates)) {
            die('load file');
        }

        if (!is_array($templates)) return $output;

        foreach ($templates as $template) {
            if (is_string($template)) {
                die('load file');
            }

            if (is_array($template)) {
                $template['properties'] = $this->getProperties($template);
                if (is_string($template['category'])) {
                    $template['category'] = [$template['category']];
                }

                $output[] = $template;
            }
        }

        return $output;
    }

    /**
     * @param string|array $children
     *
     * @return array
     */
    private function getCategories($children = null): array
    {
        $output = [];

        if ($children === null) {
            if (!isset($this->config['categories'])) return $output;

            $categories = $this->config['categories'];
        } else {
            $categories = $children;
        }

        if (is_string($categories)) {
            die('load file');
        }

        if (!is_array($categories)) return $output;

        foreach ($categories as $category) {
            if (is_string($category)) {
                // check if file exists and load children if file exists

                $category = ['name' => $category];
            }

            if (is_array($category)) {
                if (!empty($category['children'])) {
                    $category['children'] = $this->getCategories($category['children']);
                }

                $output[] = $category;
            }
        }

        return $output;
    }

    private function getPlugins(): array
    {
        $output = [];

        if (!isset($this->config['plugins'])) return $output;

        $plugins = $this->config['plugins'];
        if (is_string($plugins)) {
            die('load file');
        }

        if (!is_array($plugins)) return $output;

        foreach ($plugins as $plugin) {
            if (is_string($plugin)) {
                die('load file');
            }

            if (is_array($plugin)) {
                $plugin['properties'] = $this->getProperties($plugin);
                if (isset($plugin['category']) && is_string($plugin['category'])) {
                    $plugin['category'] = [$plugin['category']];
                }

                if (isset($plugin['events']) && is_array($plugin['events'])) {
                    $events = [];
                    foreach ($plugin['events'] as $event) {
                        if (is_string($event)) {
                            $event = ['name' => $event];
                        }

                        $events[] = $event;
                    }
                    
                    $plugin['events'] = $events;
                }

                $output[] = $plugin;
            }
        }

        return $output;
    }

    private function getProperties(array $element): array
    {
        if (empty($element['properties'])) return [];
        $properties = $element['properties'];

        if (is_string($properties)) {
            die('load file');
        }

        if (!is_array($properties)) return [];

        $output = [];

        foreach ($element['properties'] as $property) {
            if (is_string($property)) {
                die('load file');
            }

            if (is_array($property)) {
                $output[] = $property;
            }
        }

        return $output;
    }

    private function parseJSON(string $string): array
    {
        return json_decode($string, true);
    }

    private function parseYAML(string $string): array
    {
        return Yaml::parse($string);
    }

}