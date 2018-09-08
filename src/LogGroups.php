<?php

namespace DevDavido\Reporto;

use Illuminate\Support\Collection;

class LogGroups
{
    /**
     * @var Collection
     */
    private $groups;

    /**
     * Create log group for each group from config.
     */
    public function __construct()
    {
        $this->groups = collect();
        collect(config('reporto.groups'))->each(function($group) {
            $this->groups->push($this->createLogGroup($group));
        });
    }

    /**
     * @return LogGroup
     */
    public function createLogGroup($name) {
        return new LogGroup($name, config('reporto.endpoint_max_age'), config('reporto.include_subdomains'));
    }

    /**
     * @return string
     */
    public function __toString() {
        return trim($this->groups->toJson(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), '[]');
    }
}