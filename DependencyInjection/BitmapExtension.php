<?php

namespace Bitmap\Bundle\BitmapBundle\DependencyInjection;

use Bitmap\Bitmap;
use Monolog\Logger;
use PDO;
use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;

class BitmapExtension extends Extension implements PrependExtensionInterface
{
    const MYSQL_DEFAULT_HOST = '127.0.0.1';
    const MYSQL_DEFAULT_PORT = 3306;

    public function prepend(ContainerBuilder $container)
    {
        if ($container->hasExtension('monolog')) {
            //$container->getExtension('monolog')->load($configs, $container);
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $connections = [];

        foreach ($config['connections'] as $name => $options) {
            $connections[$name] = $this->getConnection($options);
        }

        $definition = new Definition(Bitmap::class );
        $definition->setFactory([Bitmap::class, 'current']);
        $definition->addArgument($connections);
        $container->setDefinition('bitmap', $definition);
    }

    /**
     * @param $options
     * @return array
     *
     * @throws Exception
     */
    protected function getConnection($options)
    {
        switch ($options['scheme']) {
            case "mysql":
                return [
                    'dsn' => sprintf(
                            "mysql:dbname=%s;host=%s;charset=utf8",
                            $options['name'],
                            self::option($options, 'host', self::MYSQL_DEFAULT_HOST)
                        ),
                    'user' => self::option($options, 'user'),
                    'password' => self::option($options, 'password'),
                    'default' => self::option($options, 'default', false)
                ];
            default:
                throw new Exception("");
        }
    }

    private static function option($options, $name, $default = null)
    {
        return isset($options[$name]) ? $options[$name] : $default;
    }
}