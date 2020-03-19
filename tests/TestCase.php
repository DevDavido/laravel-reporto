<?php

namespace DevDavido\Reporto\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use DevDavido\Reporto\ReportoServiceProvider;
use DevDavido\Reporto\Middleware\AddReportToHeader;
use Orchestra\Testbench\TestCase as Orchestra;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class TestCase extends Orchestra
{
    protected $uri = '/reporto-test';

    protected function setUp(): void
    {
        parent::setUp();

        $this->initializeDirectory($this->getTempDirectory());

        $this->setUpRoutes();

        $this->setUpGlobalMiddleware();
    }

    protected function initializeDirectory($directory)
    {
        if (File::isDirectory($directory)) {
            File::deleteDirectory($directory);
        }

        File::makeDirectory($directory);
    }

    protected function getTempDirectory($suffix = ''): string
    {
        return __DIR__.'/temp'.($suffix == '' ? '' : $this->uri.$suffix);
    }

    protected function getTempFile(): string
    {
        $path = $this->getTempDirectory().'/test.md';

        file_put_contents($path, 'Test');

        return $path;
    }

    protected function getLogFile(): string
    {
        return $this->getTempDirectory().'/reporto.log';
    }

    protected function readLogFile(): string
    {
        return file_get_contents($this->getLogFile());
    }

    protected function getPackageProviders($app): array
    {
        return [ReportoServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->config->set('logging.channels.single', [
            'driver' => 'single',
            'path' => $this->getLogFile(),
            'level' => 'debug',
        ]);
    }

    protected function setUpRoutes()
    {
        foreach (['get', 'post', 'put', 'patch', 'delete'] as $method) {
            Route::$method($this->uri, function () use ($method) {
                return $method;
            });
        }
    }

    protected function setUpGlobalMiddleware()
    {
        $this->app[Kernel::class]->pushMiddleware(AddReportToHeader::class);
    }

    protected function makeRequest(
        string $method,
        string $uri,
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ): Request {
        $files = array_merge($files, $this->extractFilesFromDataArray($parameters));

        return Request::createFromBase(
            SymfonyRequest::create(
                $this->prepareUrlForRequest($uri), $method, $parameters,
                $cookies, $files, array_replace($this->serverVariables, $server), $content
            )
        );
    }
}
