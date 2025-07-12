<?php

namespace App\Http\Controllers;

use App\Http\Requests\Material\CreateMaterialRequest;
use App\Models\Material;
use App\Service\MaterialService;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    public function __construct(private MaterialService $materialService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMaterialRequest $request)
    {
        $data = $request->validated();

        $material = $this->materialService->create(
            $data,
            $request->file('material')
        );

        return response()->json($material, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        //
    }
}
