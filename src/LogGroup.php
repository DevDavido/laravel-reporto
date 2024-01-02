<?php

namespace DevDavido\Reporto;

use JsonSerializable;

class LogGroup implements JsonSerializable
{
    private string $group;

    private int $max_age;

    private array $endpoints;

    private bool $include_subdomains;

    /**
     * Assign all values and create new LogEndpoint.
     *
     * @param string $group
     * @param int $max_age
     * @param bool $include_subdomains
     */
    public function __construct(string $group, int $max_age, bool $include_subdomains)
    {
        $this->group = $group;
        $this->max_age = $max_age;
        $this->endpoints = [new LogEndpoint($group)];
        $this->include_subdomains = $include_subdomains;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
