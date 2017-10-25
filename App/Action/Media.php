<?php

namespace App\Action;

class Media extends \Core\Action
{
    public function upload()
    {
        try {
            var_dump($this->_request->getUploadedFiles());
            $media = new \App\Model\Media;
            $res = $media->upload($this->_request->getUploadedFiles());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
