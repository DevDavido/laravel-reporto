<?php

namespace DevDavido\Reporto;

use Illuminate\Support\Str;
use JsonSerializable;

class LogEndpoint implements JsonSerializable
{
    private string $url;

    private int $priority;

    /**
     * Create log endpoint.
     *
     * @param string $name
     * @param int $priority
     */
    public function __construct(string $name, int $priority = 1)
    {
        $this->url = route('reporto.' . Str::slug($name));
        $this->priority = $priority;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
