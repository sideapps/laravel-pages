<?php


namespace Sideapps\LaravelPages\Console\Commands;


use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class CreateStaticPageCommand extends GeneratorCommand {

    protected $name = 'page:static';

    protected $description = 'Create a new static page';

    protected $type = 'StaticPage';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        return str_replace('CLASS_NAME', $this->argument('name'), $stub);
    }

    protected function getStub()
    {
        return __DIR__.'/../../../resources/stubs/staticPageStub.stub';
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
