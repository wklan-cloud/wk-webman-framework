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

use Webman\Http\Request;
use Webman\Http\Response;

interface MiddlewareInterface
{
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(Request $request, callable $handler): Response;
}