<?php

return [
    /*
     * Use this setting to enable the reporting API header
     */
    'enabled' => env('REPORTING_API_ENABLED', true),

    /*
     * Enables the reporting API for all subdomains
     */
    'include_subdomains' => env('REPORTING_API_INCLUDE_SUBDOMAINS', false),

    /*
     * Exclude certain source files from being logged
     */
    'exclude_source_files' => env('REPORTING_API_EXCLUDE_SOURCE_FILES', ['chrome-extension://*']),

    /*
     * Defines cached lifetime of all endpoint in seconds (86400s = 1 day)
     */
    'endpoint_max_age' => env('REPORTING_API_MAX_AGE', 86400),

    /*
     * Which types of browser errors to report
     * @see https://w3c.github.io/reporting/
     */
    'groups' => [
        'default',
        'csp-endpoint',
        'network-errors'
    ],

    /*
     * If you want to set the logging route prefix
     */
    'route_prefix' => 'log'
];