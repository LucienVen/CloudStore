<?php

namespace App\Model;

class SKU extends \Core\Model
{
    /**
     * strcut the result info
     *
     * @param BaseQuery $query
     * @param int $limit
     * @param int $offset
     * @return array
     */
    private function structRes($query, $limit, $offset)
    {
        if ($total = $query->count()) {
            $spus = $query->limit($limit)->offset($offset)->fetchAll();
            foreach ($spus as $k => $spu) {
                $spus[$k] = array_merge($spus[$k], $this->from()
                                    ->where(['spu_id' => $spu['id']])
                                    ->select(null)
                                    ->select('price')->fetch());
            }
            // struct the result array
            $res['offset'] = $offset;
            $res['limit'] = $limit;
            $res['total'] = $total;
            $res['products'] = $spus;

            return $res;
        }

        throw new \Exception("Don't hava any Data!", 404);
    }

    /**
     * get search option info
     *
     * @param int $cateId1
     * @return array
     */
    public function searchOptInfo($cateId1)
    {
        // get brand name
        $brands = $this->from('spu')
                    ->groupBy('brand')
                    ->select(null)
                    ->select('brand')
                    ->fetchAll();
        foreach ($brands as $brand) {
            $res['brand'][] = $brand['brand'];
        }

        // get cate name
        $cates = $this->from('cate')
                    ->where(['pid' => $cateId1])
                    ->select(null)
                    ->select(['id', 'name'])
                    ->fetchAll();
        foreach ($cates as $cate) {
            $res['cate'][] = $cate;
        }

        // price between
        $price[] = ['begin' => 0, 'end' => 1666];
        $price[] = ['begin' => 1667, 'end' => 3332];
        $price[] = ['begin' => 3333, 'end' => 4998];
        $res['price'] = $price;

        return $res;
    }

    /**
     * get search list product info
     *
     * @param array $data
     * @return array
     */
    public function search($data)
    {
        $this->_validate->check($data, ['require' => ['cateId1']]);

        // set page config
        $offset = (!isset($data['offset']) || $data['offset'] < 0) ? 0 : $data['offset'];
        $limit = (!isset($data['limit']) || $data['limit'] <= 0) ? \Core\Config::get('page_limit') : $data['limit'];

        // init where query
        $where = ['is_delete' => 0];

        // set brand
        if (isset($data['brand'])) {
            $where = array_merge($where, ['brand' => $data['brand']]);
        }

        // set cate2 id
        if (isset($data['cateId2'])) {
            $where = array_merge($where, ['cate_id' => $data['cateId2']]);
        } else {
            $tmp = $this->from('cate')->where(['pid' => $data['cateId1']])->select(null)->select('id')->fetchAll();
            foreach ($tmp as $value) {
                $cate2[] = $value['id'];
            }
            $where = array_merge($where, ['cate_id' => $cate2]);
        }

        // set order
        if (isset($data['orderBy']) && $data['orderBy'] != 'default') {
            $orderBy = ['show_price '.$data['orderBy']];
        } else {
            $orderBy = ['total_sold DESC', 'show_price ASC'];
        }

        // structure query
        $SPUQuery = $this->from('spu')->where($where)->orderBy($orderBy);
        // get default result
        return $this->structRes($SPUQuery, $limit, $offset);
    }

    /**
     * hot product info.
     *
     * @param array $params
     *
     * @return array
     */
    public function listProductInfo($params)
    {
        // init page config
        $offset = (!isset($params['offset']) || $params['offset'] < 0) ? 0 : $params['offset'];
        $limit = (!isset($params['limit']) || $params['limit'] <= 0) ? \Core\Config::get('page_limit') : $params['limit'];

        // construct hot product query
        if ('hot' == $params['type']) {
            $where = ['is_hot_sale' => 1, 'is_delete' => 0];
        } elseif ('suggest' == $params['type']) {
            $where = ['is_recommd' => 1, 'is_delete' => 0];
        }

        // structure query
        $SPUQuery = $this->from('spu')->where($where);
        $res = $this->structRes($SPUQuery, $limit, $offset);
        // add product param
        $res['type'] = $params['type'];

        return $res;
    }

    /**
     * get product detail info
     *
     * @param int $spuId
     * @return array
     */
    public function detailInfo($spuId)
    {
        // get spu info
        $spu = $this->from('spu')->where(['id' => $spuId, 'is_delete' => 0])->fetch();
        if (!$spu) {
            throw new \Exception("Product Don't Exists!", 404);
        }

        // get sku info
        $skus = $this->from()->where(['spu_id' => $spuId, 'is_delete' => 0])->fetchAll();
        foreach ($skus as $k => $sku) {
            // get sku attrbute info
            $skus[$k]['attr'] = $this->from('sku_attr')->where(['sku_id' => $sku['id']])->fetchAll();
        }

        // get desc info
        $spu['desc'] = $this->from('spu_detail')
                                    ->where(['spu_id' => $spu['id']])
                                    ->select(null)
                                    ->select(['type', 'value'])
                                    ->fetchAll();

        $spu['skus'] = $skus;

        return $spu;
    }
}
