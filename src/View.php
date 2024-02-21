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

interface View
{
    /**
     * Render.
     * @param string $template
     * @param array $vars
     * @param string|null $app
     * @return string
     */
    public static function render(string $template, array $vars, string $app = null): string;
}