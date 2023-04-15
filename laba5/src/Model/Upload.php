<?php

namespace App\Model;


class Upload {

    private const UPLOADS_PATH = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "uploads";

    private const ALLOWED_MIME_TYPES_MAP = [
        "image/jpeg" => ".jpg",
        "image/png" => ".png",
        "image/webp" => ".webp",
    ];

    public function __construct(){
        
    }

    public function moveImageToUploads(array $fileInfo): string
    {
        $fileName = $fileInfo["name"];
        $srcPath = $fileInfo["tmp_name"];
        $fileType = mime_content_type($srcPath);
        
        $imageExt = Upload::ALLOWED_MIME_TYPES_MAP[$fileType] ?? null;
    
        if (!$imageExt) 
        {
            throw new \InvalidArgumentException("File '$fileName' has non-image type '$fileType'");
        }
    
        $destFileName = uniqid('image', true) . $imageExt;
    
        return $this->moveFileToUploads($fileInfo, $destFileName);
    }

    public function getUploadPath(string $fileName): string
    {
        $uploadsPath = realpath(Upload::UPLOADS_PATH);
        if (!$uploadsPath || !is_dir($uploadsPath)) {
            throw new \RuntimeException('Invalid uploads path: ' . Upload::UPLOADS_PATH);
        }
    
        return $uploadsPath . DIRECTORY_SEPARATOR . $fileName;
    }

    public function getUploadUrlPath(string $fileName): string
    {
        return "/uploads/$fileName";
    }

    public function moveFileToUploads(array $fileInfo, string $destFileName): string
    {
        $fileName = $fileInfo['name'];
        $destPath = $this->getUploadPath($destFileName);
        $srcPath = $fileInfo['tmp_name'];
        if (!@move_uploaded_file($srcPath, $destPath)) {
            throw new \RuntimeException("Failed to upload file $fileName");
        }

        return $destFileName;
    }

}