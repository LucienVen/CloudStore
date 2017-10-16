<?php

namespace App\Action;

class Address extends \Core\Action
{
    /**
     * info
     *
     * @return Response
     */
    public function info()
    {
        try{
            $res = $this->_model->info($this->_container->get('jwt')['aud']);
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * add address
     *
     * @return Response
     */
    public function add()
    {
        try{
            $res = $this->_model->add($this->_container->get('jwt')['aud'], $this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * update address
     *
     * @return Response
     */
    public function updateInfo()
    {
        try{
            $res = $this->_model->updateInfo($this->_args['address_id'], $this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * delete address
     *
     * @return Response
     */
    public function delete()
    {
        try{
            $res = $this->_model->deleteInfo($this->_args['address_id']);
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
