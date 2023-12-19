<?php

use Illuminate\Support\Str;
function uploadImage($folder, $image){
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move('uploads/'.$folder.'/', $imageName);
    return $imageName;
}

function removeOldImage($image, $folder = ''){
    $image = basename($image);
    $image = public_path('uploads' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $image); // to reach to public folder
    if (file_exists($image)) {
        unlink($image); //delete from folder
    }
}

// function removeOldImage($image, $folder = '') {
//     $imagePath = 'uploads' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . Str::after($image, 'uploads/'.$folder);
//     $imageFullPath = public_path($imagePath);
//     return $imageFullPath;
//     if (file_exists($imageFullPath)) {
//         unlink($imageFullPath); // delete from folder
//     }
// }
