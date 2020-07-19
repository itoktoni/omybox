<?php

namespace App\Http\Services;

use DataTables;
use Plugin\Alert;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Services\MasterService;
use App\Dao\Interfaces\CoreInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class CoreService extends MasterService
{
    public $visible = [
        'create', 'list', 'create', 'data', 'stock'
    ];

    public function getGroupModuleAction($model)
    {
        return $model->joinAction()->get()->pluck('conn_ma_action');
    }

    public function getGroupModuleModule($model)
    {
        return $model->modules()->pluck('module_code');
    }

    public function getGroupModuleModuleActive($model)
    {
        return $model->active()->get()->pluck('module_code');
    }

    public function getGroupModuleController($data)
    {
        $controller = [];
        if ($data->group_module_modular == 1) {
            $folder    = ucfirst($data->group_module_folder);
            $directory = Storage::disk('modules')->files($folder . '/Http/Controllers');
            $remove = array_diff($directory, [$folder . '/Http/Controllers/.gitkeep']);

            $controllerName = collect($remove)->map(function ($item) use ($folder) {
                $deleteFolder     = str_replace($folder . '/Http/Controllers/', '', $item);
                $deleteController = str_replace('Controller.php', '', $deleteFolder);
                return $deleteController;
            });
            $controller = $controllerName;
        }
        return $controller;
    }

    public function saveConnectionModuleAction(CoreInterface $repository)
    {
        $data = request()->all();
        if (!empty($data['real_act'])) {
            try {
                DB::beginTransaction();

                $path   = $data['group_module_code'];
                $folder = $data['group_module_folder'];
                $dataController = $data['controller'];

                $repository->deleteModule($folder);
                foreach ($data['real_act'] as $head => $detail) {

                    $code       = $path . '_' . Str::snake($head);
                    $controller = $head;
                    $moduleName = ucwords(str_replace('_', ' ', Str::snake($head)));
                    $act        = $detail;

                    $enable = in_array($controller, $dataController) ? 1 : 0;

                    $repository->saveModule($code, $moduleName, $controller, $folder, $enable);
                    $repository->deleteAction($code);
                    $repository->deleteModuleConnectionAction($code);

                    try {
                        if (!empty($act)) {
                            foreach ($act as $function) {
                                $visible = '0';
                                if (in_array($function, $this->visible) || strpos($controller, 'Report') !== false) {
                                    $visible = '1';
                                }

                                $split = explode('_', $function);
                                $name = ucwords(str_replace('_', ' ', $function)) . ' ' . $moduleName;
                                if (count($split) > 1) {
                                    $name = ucwords(str_replace('_', ' ', $function));
                                }
                                $pathSave = '\Modules\\' . ucfirst($path) . '\Http\Controllers\\' . $controller . 'Controller';
                                $repository->saveAction($code, $name, $function, $controller, $function, $pathSave, $visible);
                            }
                        }

                        session()->put('success', 'Data Has Been Saved !');
                    } catch (QueryException $e) {
                        session()->flash('alert-danger', $e->getMessage());
                    }
                }
                if (!empty($data['act'])) {
                    foreach ($data['act'] as $head_act => $detail_act) {
                        $code_act  = $path . '_' . Str::snake($head_act);
                        $act_detail = $detail_act;

                        foreach ($act_detail as $func) {
                            $repository->saveModuleAction($code_act, $func);
                        }
                    }
                }

                DB::commit();
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollBack();
            }
        }
    }

    public function saveConnectionAction(CoreInterface $repository)
    {
        $data = request()->all();
        $code = $data['module_code'];
        $controller = $data['module_controller'];
        $name = $data['module_name'];
        $folder = $data['module_folder'];
        $act = $data['act'];

        if (!empty($data)) {
            try {
                if (!empty($act)) {

                    $repository->deleteAction($code);

                    foreach ($act as $function) {
                        $visible = '0';
                        if (in_array($function, $this->visible) || strpos($controller, 'Report') !== false) {
                            $visible = '1';
                        }

                        $split = explode('_', $function);
                        $name = ucwords(str_replace('_', ' ', $function)) . ' ' . $controller;
                        if (count($split) > 1) {
                            $name =  ucwords(str_replace('_', ' ', Str::snake($function)));
                        }

                        $pathSave = '\App\Http\Controllers\\' . $controller . 'Controller';
                        if ($folder) {
                            $pathSave = '\Modules\\' . ucfirst($folder) . '\Http\Controllers\\' . $controller . 'Controller';
                        }
                        $repository->saveAction($code, $name, $function, $controller, $function, $pathSave, $visible);
                    }
                }

                $repository->deleteModuleConnectionAction($code);

                if (!empty($data['actions'])) {
                    foreach ($data['actions'] as $func) {

                        $repository->saveModuleAction($code, $func);
                    }
                }

                session()->put('success', 'Data Has Been Saved !');
            } catch (QueryException $e) {
                session()->flash('alert-danger', $e->getMessage());
            }
        }
    }

    public function saveGroupModuleWithUser($repository)
    {
        $id = request()->query('code');
        if (request()->exists('group')) {
            $repository->saveConnectionModule($id, request()->get('group'));
        }
    }

    public function saveGroupModule($repository)
    {
        $id =  $id = request()->query('code');
        $repository->saveGroupModule($id, request()->get('group'));
    }
}
