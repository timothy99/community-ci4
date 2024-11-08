<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

/**
 * Debug toolbar filter
 *
 * @see \CodeIgniter\Filters\DebugToolbarTest
 */
class DebugToolbar implements FilterInterface
{
    /**
     * We don't need to do anything here.
     *
     * @param list<string>|null $arguments
     */
    public function before(RequestInterface $request, $arguments = null)
    {
    }

    /**
     * If the debug flag is set (CI_DEBUG) then collect performance
     * and debug information and display it in a toolbar.
     *
     * @param list<string>|null $arguments
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 이제 ajax등 툴바를 사용하지 말아야 하는 페이지에 대해서는 툴바가 보이지 않게 수정한다.
        $path = $request->getUri()->getPath();
        $path_arr = array();
        $path_arr[] = "/csl/calendar/month";

        if (in_array($path, $path_arr)) {
            // do nothing
        } else {
            Services::toolbar()->prepare($request, $response);
        }
    }
}
