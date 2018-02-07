<?php

namespace DavidNineRoc\ApiHelper\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class MakeApiController extends GeneratorCommand
{
    protected $name = 'make:apiController';

    protected $description = '创建一个 API 控制器';

    protected $type = 'Controller';

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        dd($this);
        if ($this->option('parent')) {
            return __DIR__.'/../Controllers/NestedController.tpl';
        } elseif ($this->option('model')) {
            return __DIR__.'/../Controllers/ModelController.tpl';
        } elseif ($this->option('resource')) {
            return __DIR__.'/../Controllers/ResourceController.tpl';
        }

        return __DIR__.'/../Controllers/Controller.tpl';
    }

    /**
     * 获取控制器默认命名空间
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.config('apihelper.controller_namespace', '\Http\Controllers\Api');
    }

    /**
     * 使用给定的名称构建类。
     *
     * 如果我们已经在基命名空间中，则删除基本控制器导入。
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        // 同级目录所以不需要
        $replace["use {$controllerNamespace}\ApiController;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * 重写父类替换方法，因为 ApiController 的命名空间也是动态的
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    public function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            [
                'DummyNamespace',
                'DummyRootNamespace',
                'NamespacedDummyUserModel',
                'DummyApiNamespace',
                'DummyApiName'
            ],
            [
                $this->getNamespace($name),
                $this->rootNamespace(),
                config('auth.providers.users.model'),
                $this->getApiNamespace(),
                $this->getApiName(),
            ],
            $stub
        );

        return $this;
    }

    /**
     * 获取 Api 基类的命名空间
     * @return string
     */
    protected function getApiNamespace()
    {
        $namespace = config('apihelper.base_api_namespace', '\App\Http\Controllers\Api');
        return ltrim($namespace, '\\/');
    }

    /**
     * 获取 Api 基类的名字
     * @return string
     */
    protected function getApiName()
    {
        return config('apihelper.base_api_name', 'ApiController');
    }

    /**
     * 为父控制器构建替换。
     *
     * @return array
     */
    protected function buildParentReplacements()
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        if (!class_exists($parentModelClass)) {
            if ($this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $parentModelClass]);
            }
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * 建立模型替换值。
     *
     * @param array $replace
     *
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (!class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * 获取完全限定的模型类名。
     *
     * @param string $model
     *
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (!Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace.$model;
        }

        return $model;
    }

    /**
     * 获取控制台命令选项。
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],

            ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],
        ];
    }
}
