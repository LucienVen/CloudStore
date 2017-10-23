<?php

namespace App\Action;

class SKU extends \Core\Action
{
    /**
     * get product list info
     *
     * @return Response
     */
    public function simpleInfo()
    {
        try {
            $res = $this->_model->listProductInfo($this->_request->getQueryParams());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * get sku detail info
     *
     * @return Response
     */
    public function detailInfo()
    {
        try {
            $res = $this->_model->detailInfo($this->_args['spu_id']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * get search option info
     *
     * @return Response
     */
    public function searchOptInfo()
    {
        try {
            $res = $this->_model->searchOptInfo($this->_request->getQueryParams()['cateId1']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * search page
     *
     * @return Response
     */
    public function search()
    {
        try {
            $res = $this->_model->search($this->_request->getParsedBody());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
