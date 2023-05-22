<?php

namespace App\Http\Traits;

trait FirebaseStorageFileProcessing
{
    public function uploadFirebaseStorageFile($file, $file_path)
    {
        $bucket = app('firebase.storage')->getBucket();
        $file_reference = $bucket->upload(fopen($file->getRealPath(), 'r'), [
            'name' => $file_path
        ]);
        // info("File uploaded to Firebase Storage. File: " . $file_path);
        // info("File uploaded to Firebase Storage. File URL: " . $this->getUploadedFirebaseFileURL($file_path));
        return $file_reference;
    }


    public function getUploadedFirebaseFileReferenceByName($name){
        $bucket = app('firebase.storage')->getBucket();
        $object = $bucket->object($name);
        return $object;
    }


    public function deleteFirebaseStorageFile($file_path)
    {
        $bucket = app('firebase.storage')->getBucket();
        $object = $bucket->object($file_path);
        $object->delete();
    }

    public function getUploadedFirebaseFileURL($file_path)
    {
        $bucket = app('firebase.storage')->getBucket();
        $object = $bucket->object($file_path);
        $expiresAt = new \DateTime('tomorrow');
        if ($object->exists()) {
            $imageURL = $object->signedUrl($expiresAt);
        } else {
            $imageURL = '';
        }
        return $imageURL;
    }
}
