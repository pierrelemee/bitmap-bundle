<?php

namespace Bitmap\Bundle\BitmapBundle\DependencyInjection;

use Bitmap\Bitmap;
use Bitmap\BitmapBuilder;
use PDO;
use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class BitmapExtension extends Extension
{
    const MYSQL_DEFAULT_HOST = '127.0.0.1';
    const MYSQL_DEFAULT_PORT = 3306;

    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $builder = new BitmapBuilder();

        foreach ($config['connections'] as $name => $options) {
            $builder->addConnection($name, $this->getConnection($options), $name === 'default');
        }

        Bitmap::initialize($builder);

        $definition = new Definition(BitmapBuilder::class );
        $definition->setFactory([Bitmap::class, 'current']);
        $container->setDefinition('bitmap', $definition);
    }

    protected function getConnection($options)
    {
        switch ($options['scheme']) {
            case "mysql":
                return new PDO(
                    sprintf(
                        "mysql:dbname=%s;host=%s;charset=utf8",
                        $options['name'],
                        self::option($options, 'host', self::MYSQL_DEFAULT_HOST)
                    ),
                    self::option($options, 'user'),
                    self::option($options, 'password')
                );
            default:
                throw new Exception("");
        }
    }

    private static function option($options, $name, $default = null)
    {
        return isset($options[$name]) ? $options[$name] : $default;
    }
}