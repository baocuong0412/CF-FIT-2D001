<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    /**
     * Upload một ảnh duy nhất lên Cloudinary
     */
    public function uploadImageToCloudinary($file, $folder)
    {
        if ($file) {
            $uploadedImage = Cloudinary::upload($file->getRealPath(), ['folder' => $folder]);
            return $uploadedImage ? $uploadedImage->getSecurePath() : null;
        }
        return null;
    }

    /**
     * Upload nhiều ảnh lên Cloudinary
     */
    public function uploadImagesToCloudinary($files, $folder)
    {
        $imageUrls = [];
        if ($files) {
            foreach ($files as $file) {
                $imageUrls[] = $this->uploadImageToCloudinary($file, $folder);
            }
        }
        return $imageUrls;
    }
}
