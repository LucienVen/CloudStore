<?php

namespace App\Action;

class Media extends \Core\Action
{
    /**
     * for spu detail img upload
     *
     * @return Response
     */
    public function detailFileUpload()
    {
        try {
            $media = new \App\Model\Media;
            $res = $media->detailFileUpload(\Core\Config::get('media_path'), $this->_request->getUploadedFiles());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
