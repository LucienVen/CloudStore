<?php

namespace App\Model;

class Media extends \Core\Model
{
    /**
     * upload file.
     *
     * @param string      $directory
     * @param UploadFiles $files
     * @param boolean     $desc
     *
     * @return array
     */
    public function detailFileUpload($directory, $files, $desc)
    {
        $filedata = [];
        foreach ($files as $file) {
            if (UPLOAD_ERR_OK != $file->getError()) {
                throw new \Exception($file->getError(), 500);
            }
            $filedata += $this->upload($directory, $file);
        }

        if ($desc) {
            $res['errno'] = 0;
            $res['data'] = array_values($filedata);
        } else {
            $res = $filedata;
        }

        return $res;
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
    public function upload($directory, $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        // random name
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $filepath = ROOT_PATH.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename;
        $fileurl = SERVER_URL.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename;

        $uploadedFile->moveTo($filepath);
        $res = $this->saveTo(['path' => $filepath, 'url_path' => $fileurl, 'type' => 0]);

        return array($res['id'] => $res['url_path']);
    }

    /**
     * save file path info to database
     *
     * @param array $data
     * @return array
     */
    private function saveTo($data)
    {
        $this->_validate->check($data, [
            'require' => ['path', 'url_path', 'type'],
            'choose' => ['type' => '0,1,2'],
            'autotime' => 'create_time',
            'autoupdate' => 'update_time',
        ]);

        if ($mediaId = $this->insertInto('media')->field()->values($data)->execute()) {
            return $this->from('media')->where(['id' => $mediaId])->fetch();
        }

        throw new \Exception('Upload File Error!', 500);
    }
}
