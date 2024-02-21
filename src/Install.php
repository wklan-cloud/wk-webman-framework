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

class Install
{
    const WEBMAN_PLUGIN = true;

    /**
     * @var array
     */
    protected static array $pathRelation = [
        'start.php' => 'start.php',
        'windows.php' => 'windows.php',
        'core/support/Bootstrap.php' => '/core/support/Bootstrap.php',
        'core/support/Helpers.php' => '/core/support/Helpers.php',
    ];

    /**
     * Install
     * @return void
     */
    public static function install(): void
    {
        static::installByRelation();
    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {

    }

    /**
     * InstallByRelation
     * @return void
     */
    public static function installByRelation(): void
    {
        foreach (static::$pathRelation as $source => $dest) {
            if ($pos = strrpos($dest, '/')) {
                $parentDir = base_path() . '/' . substr($dest, 0, $pos);
                if (!is_dir($parentDir)) {
                    mkdir($parentDir, 0777, true);
                }
            }
            $sourceFile = __DIR__ . "/$source";
            copy_dir($sourceFile, base_path() . "/$dest", true);
            echo "Create $dest\r\n";
            if (is_file($sourceFile)) {
                @unlink($sourceFile);
            }
        }
    }

}