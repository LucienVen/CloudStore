<?php

namespace App\Model;

class Cart extends \Core\Model
{
    /**
     * get cart product info
     *
     * @param int $uid
     * @return array
     */
    public function info($uid)
    {
        $query = $this->from()->where(['uid' => $uid, 'is_delete' => 0]);
        $num = $query->count();
        $carts = $query->fetchAll();
        $totalPrice = 0;

        foreach ($carts as $key => $cart) {
            // count total price
            $totalPrice += ($cart['price'] * $cart['num']);

            // get sku info detail
            $sku = $this->from('sku')->where(['id' => $cart['sku_id'], 'is_delete' => 0])->fetch();
            $skuAttr = $this->from('sku_attr')
                            ->where(['sku_id' => $sku['id']])
                            ->select(null)
                            ->select(['id', 'attr', 'opt'])
                            ->fetchAll();
            $spu = $this->from('spu')
                        ->where(['id' => $sku['spu_id'], 'is_delete' => 0])
                        ->select(null)
                        ->select(['cate_id', 'brand', 'cover_url'])
                        ->fetch();
            $carts[$key] = array_merge($spu, $cart);
            $carts[$key]['attr'] = $skuAttr;
        }

        // strcutrue result
        $res['num'] = $num;
        $res['freight'] = $totalPrice >= \Core\Config::get('freight_limit') ? 0 : \Core\Config::get('freight');
        $res['total_price'] = $totalPrice + $res['freight'];
        $res['product'] = $carts;

        return $res;
    }

    /**
     * add new product to cart
     *
     * @param int $uid
     * @param array $data
     * @return boolean
     */
    public function add($uid, $data)
    {
        $this->_validate->check($data, [
            'require' => ['sku_id', 'name', 'num', 'price'],
            'default' => ['uid' => $uid, 'is_delete' => 0, 'status' => 1],
            'autotime' => 'create_time',
            'autoupdate' => 'update_time'
        ]);

        if ($this->insertInto()->field()->values($data)->execute()) {
            return true;
        }

        throw new \Exception("Insert Error!", 500);
    }

    /**
     * update product info
     *
     * @param array $data
     * @return boolean
     */
    public function updateInfo($data)
    {
        $this->_validate->check($data, [
            'require' => ['cart_id', 'num'],
            'autoupdate' => 'update_time'
        ]);

        if ($this->update()->field()->set($data)->where(['id' => $data['cart_id']])->execute()) {
            return true;
        }

        throw new \Exception("Update Error!", 500);
    }

    /**
     * delete product in cart
     *
     * @param int $cartId
     * @return boolean
     */
    public function deleteInfo($cartId)
    {
        if ($this->update()->set(['is_delete' => 1])->where(['id' => $cartId])->execute()) {
            return true;
        }

        throw new \Exception("Delete Error!", 500);
    }
}
