<?php

namespace App\Action;

class Orders extends \Core\Action
{
    /**
     * get order info.
     */
    public function info()
    {
        try {
            // get special order
            if (isset($this->_args['order_id']) && !empty($this->_args['order_id'])) {
                $res = $this->_model->info($this->_args['order_id']);
            } else {
                // get all order
                $res = $this->_model->allInfo($this->_container->get('jwt')['aud'], $this->_request->getQueryParams());
            }
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * create order.
     */
    public function create()
    {
        try {
            $res = $this->_model->create($this->_container->get('jwt')['aud'], $this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * call by thrid api
     * return the result of trade.
     */
    public function payReturn()
    {
        try {
            $res = $this->_model->payReturn($this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * update express info
     */
    public function express()
    {
        try {
            $res = $this->_model->express($this->_args['order_id'], $this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * change order status
     */
    public function check()
    {
        try {
            $res = $this->_model->check($this->_args['order_id'], $this->_container->get('jwt')['aud']);
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * delete order (false)
     */
    public function deleteOrder()
    {
        try {
            // cancel or delete
            if ($this->_request->getQueryParams()['cancel'] == '1') {
                $res = $this->_model->cancel($this->_args['order_id']);
            } else {
                $res = $this->_model->deleteOrder($this->_args['order_id']);
            }
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * get payment info
     */
    public function payInfo()
    {
        try {
            $res = $this->_model->payInfo($this->_args['order_id']);
        } catch(\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
