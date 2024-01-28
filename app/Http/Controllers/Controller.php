<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * store or update image
     */
    public function storeAndUpdateImage($request, $objet, $folderNameImage)
    {

        $data = $request->validated();

        $image = $request->validated('image');
        if ($image == null || $image->getError()) {
            return $data;
        }

        if ($objet->image) {
            Storage::disk('public')->delete($objet->image);
        }

        $data['image'] = $image->store($folderNameImage, 'public');
        return $data;
    }
}
