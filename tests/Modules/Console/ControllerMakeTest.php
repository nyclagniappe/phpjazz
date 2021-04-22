<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Testing\PendingCommand;
use Illuminate\Filesystem\Filesystem;

class ControllerMakeTest extends ATestCase
{
    protected string $myCommand = 'make:controller';
    protected string $myComponent = 'Http.Controllers';

    public function setUp(): void
    {
        parent::setUp();

        $contents = '<?php' . PHP_EOL;
        $contents .= 'namespace {{NAMESPACE}};' . PHP_EOL;
        $contents .= 'use Illuminate\Foundation\Auth\Access\AuthorizesRequests;' . PHP_EOL;
        $contents .= 'use Illuminate\Foundation\Bus\DispatchesJobs;' . PHP_EOL;
        $contents .= 'use Illuminate\Foundation\Validation\ValidatesRequests;' . PHP_EOL;
        $contents .= 'use Illuminate\Routing\Controller as BaseController;' . PHP_EOL;
        $contents .= 'class Controller extends BaseController {' . PHP_EOL;
        $contents .= 'use AuthorizesRequests, DispatchesJobs, ValidatesRequests;' . PHP_EOL;
        $contents .= '}' . PHP_EOL;

        $file = new Filesystem();

        $path = $this->getMyPath('Controller', null);
        $ns = substr($this->getMyClass('Controller', null), 0, -11);
        if (!is_dir(dirname($path))) {
            $file->makeDirectory(dirname($path), 0755, true);
        }
        $file->put($path, str_replace('{{NAMESPACE}}', $ns, $contents));
        $file->requireOnce($path);

        $path = $this->getMyPath('Controller', self::MODULE);
        $ns = substr($this->getMyClass('Controller', self::MODULE), 0, -11);
        if (!is_dir(dirname($path))) {
            $file->makeDirectory(dirname($path), 0755, true);
        }
        $file->put($path, str_replace('{{NAMESPACE}}', $ns, $contents));
        $file->requireOnce($path);
    }

    protected function createArtisan(string $command, array $args = []): PendingCommand
    {
        $question = 'Model does not exist. Do you want to generate it?';

        $artisan = parent::createArtisan($command, $args);
        if (isset($args['--parent'])) {
            $artisan->expectsConfirmation(sprintf($question, $args['--parent']), 'yes');
        }
        if (isset($args['--model'])) {
            $artisan->expectsConfirmation(sprintf($question, $args['--model']), 'yes');
        }
        return $artisan;
    }

    public function provider(): array
    {
        return [
            ['MyController', null, null],
            ['MyModelController', null, ['--model' => 'MyControllerModel']],
            ['MyParentController', null, [
                '--model' => 'MyControllerModelWithParent',
                '--parent' => 'MyControllerParent'
            ]],
            ['MyResourceController', null, ['--resource' => true]],
            ['MyInvokableController', null, ['--invokable' => true]],
            ['MyApiController', null, ['--api' => true]],
            ['MyApiModelController', null, ['--api' => true, '--model' => 'MyControllerApiModel']],
            ['MyApiParentController', null, [
                '--api' => true,
                '--model' => 'MyApiModelWithParent',
                '--parent' => 'MyApiParent']
            ],

            ['MyController', self::MODULE, null],
            ['MyModelController', self::MODULE, ['--model' => 'MyControllerModel']],
            ['MyParentController', self::MODULE, [
                '--model' => 'MyControllerModelWithParent',
                '--parent' => 'MyControllerParent'
            ]],
            ['MyResourceController', self::MODULE, ['--resource' => true]],
            ['MyInvokableController', self::MODULE, ['--invokable' => true]],
            ['MyApiController', self::MODULE, ['--api' => true]],
            ['MyApiModelController', self::MODULE, ['--api' => true, '--model' => 'MyControllerApiModel']],
            ['MyApiParentController', self::MODULE, [
                '--api' => true,
                '--model' => 'MyApiModelWithParent',
                '--parent' => 'MyApiParent']
            ],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        $args = $this->myArgs;
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);

        $baseClass = $this->getMyClass('Controller', null);
        if (isset($args[$this->myModuleKey])) {
            $baseClass = $this->getMyClass('Controller', $args[$this->myModuleKey]);
        }
        $this->assertTrue(is_subclass_of($class, $baseClass));

        $methods = $this->getAvailableMethods($args);
        foreach ($methods as $method => $expected) {
            $this->assertMethodInClass($class, $method, $expected);
        }

        $this->assertIsArray($args);
    }



    private function getAvailableMethods(array $args): array
    {
        $methods = [
            'index' => false,
            'create' => false,
            'store' => false,
            'show' => false,
            'edit' => false,
            'update' => false,
            'destroy' => false,
            '__invoke' => false,
        ];

        if (isset($args['--invokable'])) {
            $methods['__invoke'] = true;
        }

        if (
            isset($args['--model']) ||
            isset($args['--parent']) ||
            isset($args['--resource']) ||
            isset($args['--api'])
        ) {
            $methods['index'] = true;
            $methods['create'] = true;
            $methods['store'] = true;
            $methods['show'] = true;
            $methods['edit'] = true;
            $methods['update'] = true;
            $methods['destroy'] = true;
        }

        if (isset($args['--api'])) {
            $methods['create'] = false;
            $methods['edit'] = false;
        }

        return $methods;
    }
}
