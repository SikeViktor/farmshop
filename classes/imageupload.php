<?php
class ImageUploader {
    private $uploadDir;
    private $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    
    public function __construct($uploadDir) {
        $this->uploadDir = $uploadDir;
    }
    
    public function uploadImage($file, $newFileName) {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileError === UPLOAD_ERR_OK) {
            if (in_array($fileExt, $this->allowedExtensions)) {
                if ($fileSize < 1000000) {                    
                    $destination = $this->uploadDir . '/' . $newFileName;
                    if (move_uploaded_file($fileTmpName, $destination)) {
                        return $newFileName;
                    } else {
                        throw new Exception('Unable to move file');
                    }
                } else {
                    throw new Exception('File size too large');
                }
            } else {
                throw new Exception('Invalid file type');
            }
        } else {
            throw new Exception('Error uploading file');
        }
    }
}
