<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
      /**
     * store and update image
     */
    public function storeAndUpdateImage($request, $objetModel)
    {

        $data = $request->validated();

        $image = $request->validated('image');
        if ($image == null || $image->getError()) {
            return $data;
        }

        if ($objetModel->image) {
            Storage::disk('public')->delete($objetModel->image);
        }

        $data['image'] = $image->store('user', 'public');
        return $data;
    }
}
