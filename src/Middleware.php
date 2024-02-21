<?php

/**
 * This file is part of the wklan project.
 *
 * (c) euper <wklan@proton.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webman;


use RuntimeException;
use function array_merge;
use function array_reverse;
use function is_array;
use function method_exists;

class Middleware
{
    /**
     * @var array
     */
    protected static array $instances = [];

    /**
     * @param mixed $allMiddlewares
     * @param string $plugin
     * @return void
     */
    public static function load(mixed $allMiddlewares, string $plugin = ''): void
    {
        if (!is_array($allMiddlewares)) {
            return;
        }
        foreach ($allMiddlewares as $appName => $middlewares) {
            if (!is_array($middlewares)) {
                throw new RuntimeException('Bad middleware config');
            }
            if ($appName === '@') {
                $plugin = '';
            }
            if (str_contains($appName, 'plugin.')) {
                $explode = explode('.', $appName, 4);
                $plugin = $explode[1];
                $appName = $explode[2] ?? '';
            }
            foreach ($middlewares as $className) {
                if (method_exists($className, 'process')) {
                    static::$instances[$plugin][$appName][] = [$className, 'process'];
                } else {
                    // @todo Log
                    echo "middleware $className::process not exists\n";
                }
            }
        }
    }

    /**
     * @param string $plugin
     * @param string $appName
     * @param bool $withGlobalMiddleware
     * @return array
     */
    public static function getMiddleware(string $plugin, string $appName, bool $withGlobalMiddleware = true): array
    {
        $globalMiddleware = static::$instances['']['@'] ?? [];
        $appGlobalMiddleware = $withGlobalMiddleware && isset(static::$instances[$plugin]['']) ? static::$instances[$plugin][''] : [];
        if ($appName === '') {
            return array_reverse(array_merge($globalMiddleware, $appGlobalMiddleware));
        }
        $appMiddleware = static::$instances[$plugin][$appName] ?? [];
        return array_reverse(array_merge($globalMiddleware, $appGlobalMiddleware, $appMiddleware));
    }

    /**
     * @return void
     * @deprecated
     */
    public static function container($_)
    {

    }
}