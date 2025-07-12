<?php

namespace App\Service;

use App\Models\Material;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class MaterialService
{

    public function getAllMaterials()
    {
        return Material::all();
    }

    public function create(array $data, ?UploadedFile $material)
    {

        if ($material) {
            $data['material_url'] = Storage::disk('public')->url($material->store('materials', 'public'));
        }

        return Material::create($data);
    }

    public function update(Material $material, array $data)
    {
        $material->update($data);
        return $material;
    }
}