<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function getAllData()
    {
        $data = ImageResource::collection(Image::all());
        return response()->json($data);
    }

    public function uploadImage(Request $request)
    {

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif'])) {
                $imageName = $image->getClientOriginalName();
                $path = $image->storeAs("student", $imageName, "Images");
                Image::create([
                    'path' => $path
                ]);
                return response()->json($path);
            } else {
                return response()->json("Invalid file type", 400);
            }
        } else {
            return response()->json("Image not found", 400);
        }
    }
    public function deleteImage($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        Storage::delete('Images/student/' . $image->path);

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
    public function insertIntoDatabase()
    {

        $data1 = [
            'email' => "eslam@gmail.com",
            'name' => 'Admin',
            'password' => bcrypt('Admim'),
        ];
        User::create($data1);
        return 'Done';
    }
}
