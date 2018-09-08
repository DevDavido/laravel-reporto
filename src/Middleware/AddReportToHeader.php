<?php

namespace DevDavido\Reporto\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DevDavido\Reporto\LogGroups;

class AddReportToHeader
{
    const REPORT_TO = 'Report-To';

    /**
     * All response log groups.
     *
     * @var LogGroups
     */
    private $logGroups;

    /**
     * Set log groups.
     *
     * @param LogGroups $groups
     */
    public function __construct(LogGroups $groups)
    {
        $this->logGroups = $groups;
    }

    /**
     * Adds Report-To header to response.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed|Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (!$response instanceof Response || $response->headers->has(self::REPORT_TO)) {
            return $response;
        }
        $response->headers->set(self::REPORT_TO, (string) $this->logGroups);

        return $response;
    }
}