<?php

namespace App\Action;

class Cart extends \Core\Action
{
    /**
     * get cart product info
     *
     * @return Response
     */
    public function info()
    {
        try {
            $res = $this->_model->info($this->_container->get('jwt')['aud']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * add new product to cart
     *
     * @return Response
     */
    public function add()
    {
        try {
            $res = $this->_model->add($this->_container->get('jwt')['aud'], $this->_request->getParsedBody());
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * update product info
     *
     * @return Response
     */
    public function updateInfo()
    {
        try {
            if ($this->_model->updateInfo($this->_request->getParsedBody())) {
                $res = $this->_model->info($this->_container->get('jwt')['aud']);
            }
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * delete cart
     *
     * @return Response
     */
    public function deleteInfo()
    {
        try {
            if ($this->_model->deleteInfo($this->_args['cart_id'])) {
                $res = $this->_model->info($this->_container->get('jwt')['aud']);
            }
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
