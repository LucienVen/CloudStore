<?php

namespace App\Action;

class Media extends \Core\Action
{
    public function upload()
    {
        try {
            $media = new \App\Model\Media;
            $res = $media->upload(\Core\Config::get('media_path'), $this->_request->getUploadedFiles());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
