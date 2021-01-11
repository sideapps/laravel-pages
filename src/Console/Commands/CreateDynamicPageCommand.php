<?php

namespace Sideapps\LaravelPages\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class CreateDynamicPageCommand extends GeneratorCommand {

    protected $name = 'page:dynamic';

    protected $description = 'Create a new dynamic page';

    protected $type = 'DynamicPage';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        return str_replace('CLASS_NAME', $this->argument('name'), $stub);
    }

    protected function getStub()
    {
        return __DIR__.'/../../../resources/stubs/dynamicPageStub.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Pages';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the page.'],
        ];
    }

}
