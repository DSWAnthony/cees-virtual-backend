<?php

namespace App\Http\Controllers;

use App\Http\Requests\Module\CreateModuleRequest;
use App\Http\Requests\Module\UpdateModuleRequest;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use App\Service\ModuleService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function __construct(private ModuleService $moduleService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json([
        //     'data' => $this->moduleService->getAllModules()
        // ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateModuleRequest $request)
    {
        $files = [];
        foreach ($request->file('materials') as $material) {
            $files[] = $material['file'] ?? null;
        }

        $module = $this->moduleService->create(
            $request->validated(),
            $files
        );

        return new ModuleResource($module->load('materials.quiz.questions.options'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateModuleRequest $request)
    {
        $data = $request->validated();

        $module = $this->moduleService->update(
            id: $id,
            data: $data,
            material: $request->file('material')
        );

        return new ModuleResource($module);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        //
    }
}
