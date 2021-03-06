<?php

namespace App\Action;

use \App\Model\SPU;
use \App\Model\SKU;

class Product extends \Core\Action
{
    /**
     * get product list info
     *
     * @return Response
     */
    public function simpleInfo()
    {
        try {
            $SPU = new SPU;
            $res = $SPU->list($this->_request->getQueryParams());
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
            $SPU = new SPU;
            $res = $SPU->detail($this->_args['spu_id']);
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
            $SPU = new SPU;
            $res = $SPU->searchOpt($this->_request->getQueryParams()['cateId1']);
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
            $SPU = new SPU;
            $res = $SPU->search($this->_request->getParsedBody());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * add new spu/sku info
     *
     * @return Response
     */
    public function add()
    {
        try {
            $SPU = new SPU;
            $res = $SPU->add($this->_request->getParsedBody(), $this->_request->getUploadedFiles());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * get sku's attribute
     *
     * @return Response
     */
    public function info()
    {
        try {
            $SKU = new SKU;
            $res = $SKU->info($this->_args['sku_id']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * add new sku
     *
     * @return Response
     */
    public function addSKU()
    {
        try {
            $SKU = new SKU;
            $res = $SKU->add($this->_args['spu_id'], $this->_request->getParsedBody());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * add new sku
     *
     * @return Response
     */
    public function updateSKU()
    {
        try {
            $SKU = new SKU;
            $res = $SKU->updateInfo($this->_args['sku_id'], $this->_request->getParsedBody());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * update spu info
     *
     * @return Response
     */
    public function updateSPU()
    {
        try {
            $SPU = new SPU;
            $res = $SPU->updateInfo($this->_args['spu_id'], $this->_request->getParsedBody());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * delete sku info
     *
     * @return Response
     */
    public function deleteSKU()
    {
        try {
            $SKU = new SKU;
            $res = $SKU->deleteInfo($this->_args['sku_id']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * delete spu info
     *
     * @return Response
     */
    public function deleteSPU()
    {
        try {
            $SPU = new SPU;
            $res = $SPU->deleteInfo($this->_args['spu_id']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
