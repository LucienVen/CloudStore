<?php

namespace App\Model;

class Orders extends \Core\Model
{
    protected $_rules = [
        'choose' => ['type' => '1,2,3,4', 'payment' => '1,2,3,4', 'payment_status' => '0,1', 'express_status' => '0,1', 'is_delete' => '0,1', 'status' => '0,1,2,3'],
    ];

    /**
     * get spe info.
     *
     * @param int $order_id
     *
     * @return array
     */
    public function info($order_id)
    {
        if ($order = $this->from()->where(['id' => $order_id, 'is_delete' => 0, 'status' => [0, 1, 2]])->fetch()) {
            $res = $order;
            // get order_items detail
            if ($order_detail = $this->from('orders_items')->where(['order_id' => $order_id])->fetchAll()) {
                $res['items'] = $order_detail;

                return $res;
            }
            throw new \Exception('Order Detail Error!', 500);
        }

        throw new \Exception("Order Don't Exist!", 404);
    }

    /**
     * get a user all order.
     *
     * @param int   $uid
     * @param array $param
     */
    public function allInfo($uid, $param)
    {
        // init page config
        $offset = (!isset($param['offset']) || $param['offset'] < 0) ? 0 : $param['offset'];
        $limit = (!isset($param['limit']) || $param['limit'] <= 0) ? \Core\Config::get('page_limit') : $param['limit'];

        // get all orders
        if ($orders = $this->from()
                    ->where(['upload_uid' => $uid, 'is_delete' => 0, 'status' => [0, 1, 2]])
                    ->limit($limit)
                    ->offset($offset)
                    ->fetchAll()) {
            $res = $orders;
            // all order detail
            foreach ($orders as $k => $order) {
                if ($orders_detail = $this->from('orders_items')->where(['order_id' => $order['id']])->fetchAll()) {
                    $res[$k]['items'] = $order_detail;
                }
            }

            return $res;
        }

        throw new \Exception("Order Don't Exist!", 404);
    }

    /**
     * create order number.
     */
    private function createOrderNum()
    {
        do {
            // order type
            $num = \Core\Config::get('order_type')['web'];
            $num .= date('Ymd');
            $randnum = (string) rand(0, 9999999);
            for ($i = 0; $i < (7 - strlen($randnum)); ++$i) {
                $randnum .= '0';
            }
            $num .= $randnum;
        } while ($this->from()->where(['number' => $num])->fetch());

        return $num;
    }

    /**
     * request thrid pay api.
     *
     * @return string
     */
    private function createPay($data)
    {
        return '/qr_code_url';
    }

    /**
     * thrid payment api callback
     * just a demo.
     *
     * @return bool
     */
    public function payReturn($data)
    {
        if ($data['trade_status']) {
            $this->update()
            ->set(['trade_id' => $data['trade_no'], 'payment_status' => 1, 'status' => 1])
            ->where(['number' => 'out_trade_no'])
            ->execute();

            return true;
        }

        return false;
    }

    /**
     * set pay limit to system check
     * TODO.
     *
     * @param int $pay_limit
     */
    private function setPayLimit($pay_limit)
    {
        $_SESSION['pay_limit'] = $pay_limit;
    }

    /**
     * set order_items table data.
     *
     * @param array|int $data
     *
     * @return array
     */
    private function setOrderItems($order_id, $data)
    {
        // add SKU detail
        if (is_array($data)) {
            foreach ($data as $cart_id) {
                $sku = $this->from('cart')
                        ->where(['id' => $cart_id, 'is_delete' => 0])
                        ->select(null)
                        ->select(['sku_id', 'num', 'price', 'name'])
                        ->fetch();
                if (!$sku) {
                    return false;
                }
                $sku['order_id'] = $order_id;
                if (!$this->insertInto('orders_items')->field()->values($sku)->execute()) {
                    return false;
                }
                $this->update('cart')->set(['is_delete' => 1])->where('id', $cart_id)->execute();
            }
        } else {
            $sku = $this->from('sku')
                    ->leftJoin('spu ON sku.spu_id = spu.id')
                    ->where(['sku.id' => $data['sku_id'], 'is_delete' => 0])
                    ->select(null)
                    ->select(['sku.id as sku_id', 'sku.price', 'spu.name'])
                    ->fetch();
            if (!$sku) {
                return false;
            }
            $sku['num'] = $data['num'];
            $sku['order_id'] = $order_id;
            if (!$this->insertInto('orders_items')->field()->values($sku)->execute()) {
                return false;
            }
        }

        return $this->from('orders_items')->where(['order_id' => $order_id])->fetchAll();
    }

    /**
     * create an order.
     *
     * @param int   $uid
     * @param array $data
     *
     * @return array
     */
    public function create($uid, $data)
    {
        // check order field
        $this->_validate->addRules([
            'require' => ['payment', 'address_id', 'cart', 'cart_ids', 'total_price', 'sku_id', 'num', 'discount'],
            'default' => ['type' => 1, 'upload_uid' => $uid, 'payment_status' => 0, 'express_status' => 0, 'is_delete' => 0, 'status' => 0],
            'autotime' => 'create_time',
            'autoupdate' => 'update_time',
        ])->check($data);

        // check order_items field
        foreach ($data['cart_ids'] as $sku) {
            $this->_validate->check($sku, [
                'require' => ['id'],
            ]);
        }

        // check address info
        if (!$this->from('address')->where(['id' => $data['address_id']])->fetch()) {
            throw new \Exception('Address info Error!');
        }

        // create order number
        $data['number'] = $this->createOrderNum();

        // insert data
        if ($order_id = $this->insertInto()->field()->values($data)->execute()) {
            // change shopcart status
            if ($data['cart']) {
                $sku_id = $data['cart_ids'];
            } else {
                $sku_id = $data['sku_id'];
            }
            // get skus detail and insert sku detail of order
            if ($skus = $this->setOrderItems($order_id, $sku_id)) {
                // make result data
                $res = [
                    'order_id' => $order_id,
                    'order_number' => $data['number'],
                    'skus' => $skus,
                    'pay_limit' => time() + \Core\Config::get('pay_limit'),
                ];
                // thrid api return
                $res['pay_url'] = $this->createPay($data);

                // set pay limit
                $this->setPayLimit($res['pay_limit']);

                return $res;
            }
        }

        throw new \Exception('Insert Error!', 500);
    }

    /**
     * check the order for business.
     *
     * @param int   $order_id
     * @param int   $uid
     *
     * @return boolean
     */
    public function check($order_id, $uid)
    {
        // check trade means this trade is successful
        // change the sold/stock value for sku info
        if ($orderItems = $this->from('orders_items')->where(['order_id' => $order_id])->fetchAll()) {
            foreach ($orderItems as $item) {
                // get original sku and spu info
                $sku = $this->from('sku')->where(['id' => $item['sku_id'], 'is_delete' => 0])->fetch();
                $spu = $this->from('spu')->where(['id' => $sku['spu_id'], 'is_delete' => 0])->fetch();

                // change stock/sold value
                $this->update('sku')
                    ->set(['stock' => (int)$sku['stock']-(int)$item['num'],
                            'sold' => (int)$sku['sold']+(int)$item['num']])
                    ->where(['id' => $item['sku_id'], 'is_delete' => 0])
                    ->execute();
                $this->update('spu')
                    ->set(['total_sold' => (int)$spu['total_sold']+(int)$item['num']])
                    ->where(['id' => $spu['id'], 'is_delete' => 0])
                    ->execute();
            }
        } else {
            throw new \Exception("Order Don't Exist!", 404);
        }

        // check
        if ($this->update()
                ->set(['check_uid' => $uid, 'status' => 2])
                ->where(['id' => $order_id, 'is_delete' => 0])
                ->execute()) {
            return true;
        }

        throw new \Exception('Update Error!', 500);
    }

    /**
     * udpate express info.
     *
     * @param int   $order_id
     * @param array $data
     *
     * @return bool
     */
    public function express($order_id, $data)
    {
        $this->_validate->addRules([
            'require' => ['express_id', 'express_status'],
        ])->check($data);

        if ($this->update()->field()->set($data)->where(['id' => $order_id])->execute()) {
            return true;
        }

        throw new \Exception('Update Error!', 500);
    }

    /**
     * get pay info
     *
     * @param int $order_id
     * @return array
     */
    public function payInfo($order_id)
    {
        if ($res = $this->from()
            ->where(['id' => $order_id, 'is_delete' => 0])
            ->select(null)
            ->select(['id', 'number as order_number', 'upload_uid', 'total_price', 'payment', 'trade_id', 'payment_status'])
            ->fetch()) {
            $res['pay_limit'] = isset($_SESSION['pay_limit']) ? $_SESSION['pay_limit'] : 0;
            return $res;
        }

        throw new \Exception("Order Don't Exist!", 404);
    }

    /**
     * cancel order.
     *
     * @param int $order_id
     *
     * @return bool
     */
    public function cancel($order_id)
    {
        if ($this->update()->set(['status' => 3])->where(['id' => $order_id])->execute()) {
            return true;
        }

        throw new \Exception('Cancel Error!', 500);
    }

    /**
     * delete order.
     *
     * @param int $order_id
     *
     * @return bool
     */
    public function deleteOrder($order_id)
    {
        if ($this->update()->set(['is_delete' => 0])->where(['id' => $order_id])->execute()) {
            return true;
        }

        throw new \Exception('Delete Error!', 500);
    }
}
