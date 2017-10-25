<?php

namespace App\Model;

class Media extends \Core\Model
{
    public function upload($directory, $files)
    {
        foreach ($files as $file) {
            $filename[] = moveUploadedFile($directory, $file);
        }

        return $filename;
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string       $directory directory to which the file is moved
     * @param UploadedFile $uploaded  file uploaded file to move
     *
     * @return string filename of moved file
     */
    public function moveUploadedFile($directory, $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory.DIRECTORY_SEPARATOR.$filename);

        return $filename;
    }
}
