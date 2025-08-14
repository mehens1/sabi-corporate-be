<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public static function upload($file, $folder = "uploads")
    {
        try {
            $result = Cloudinary::upload($file->getRealPath(), [
                "folder" => $folder,
                "resource_type" => "auto"
            ]);
            \Log::info('Cloudinary response: ', (array)$result);
            return $result->getSecurePath();
        } catch (\Throwable $th) {
            \Log::error("Cloudinary upload failed: " . $th->getMessage());
            throw $th;
        }
    }
}
