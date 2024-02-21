<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Support\Exception;

use Throwable;
use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;

/**
 * Class Handler
 * @package Support\Exception
 */
class Handler extends ExceptionHandler
{
    public array $dontReport = [
        BusinessException::class,
    ];

    public function render(Request $request, Throwable $exception): Response
    {
        if(($exception instanceof BusinessException) && ($response = $exception->render($request)))
        {
            return $response;
        }

        return parent::render($request, $exception);
    }

}