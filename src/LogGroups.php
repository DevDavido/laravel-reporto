<?php

namespace DevDavido\Reporto;

use Illuminate\Support\Collection;

class LogGroups
{
    private Collection $groups;

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
     * @param $name string Log group name
     * @return LogGroup
     */
    public function createLogGroup(string $name): LogGroup
    {
        return new LogGroup($name, config('reporto.endpoint_max_age'), config('reporto.include_subdomains'));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return trim($this->groups->toJson(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), '[]');
    }
}
