<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Filesystem\Filesystem;

class MakeControllerTest extends ATestCase
{
    protected $myCommand = 'make:controller';
    protected $myComponent = 'Http.Controllers';

    /**
     * Set Up
     */
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
        $file->makeDirectory(dirname($path), 0755, true);
        $file->put($path, str_replace('{{NAMESPACE}}', $ns, $contents));
        require_once($path);

        $path = $this->getMyPath('Controller', $this->myModule);
        $ns = substr($this->getMyClass('Controller', $this->myModule), 0, -11);
        $file->makeDirectory(dirname($path), 0755, true);
        $file->put($path, str_replace('{{NAMESPACE}}', $ns, $contents));
        require_once($path);
    }



    /**
     * Calls Artisan
     * @param string $command
     * @param array $args
     */
    protected function callArtisan(string $command, array $args = []): void
    {
        $question = '%s Model does not exist. Do you want to generate it?';

        $artisan = $this->artisan($command, $args);
        if (isset($args['--parent'])) {
            $artisan->expectsConfirmation(sprintf($question, $args['--parent']), 'yes');
        }
        if (isset($args['--model'])) {
            $artisan->expectsConfirmation(sprintf($question, $args['--model']), 'yes');
        }
        $artisan->assertExitCode(0);
    }

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyController', false, null],
            ['MyModelController', false, ['--model' => 'MyModel']],
            ['MyParentController', false, ['--model' => 'MyModel', '--parent' => 'MyParent']],
            ['MyResourceController', false, ['--resource' => true]],
            ['MyInvokableController', false, ['--invokable' => true]],
            ['MyApiController', false, ['--api' => true]],
            ['MyApiModelController', false, ['--api' => true, '--model' => 'MyModel']],
            ['MyApiParentController', false, ['--api' => true, '--model' => 'MyModel', '--parent' => 'MyParent']],

            ['MyController', true, null],
            ['MyModelController', true, ['--model' => 'MyModel']],
            ['MyParentController', true, ['--model' => 'MyModel', '--parent' => 'MyParent']],
            ['MyResourceController', true, ['--resource' => true]],
            ['MyInvokableController', true, ['--invokable' => true]],
            ['MyApiController', true, ['--api' => true]],
            ['MyApiModelController', true, ['--api' => true, '--model' => 'MyModel']],
            ['MyApiParentController', true, ['--api' => true, '--model' => 'MyModel', '--parent' => 'MyParent']],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $baseClass = $this->getMyClass('Controller', null);
        if ($args['--module'] !== null) {
            $baseClass = $this->getMyClass('Controller', $args['--module']);
        }
        $this->assertTrue(is_subclass_of($class, $baseClass));

        $methods = $this->getAvailableMethods($args);
        foreach ($methods as $method => $expected) {
            $this->assertMethodInClass($class, $method, $expected);
        }

        $this->assertIsArray($args);
    }



    /**
     * Returns available methods
     * @param array $args
     * @return array
     */
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
