<?php

namespace App\Model;

class SPU extends \Core\Model
{
    /**
     * strcut the result info.
     *
     * @param BaseQuery $query
     * @param int       $limit
     * @param int       $offset
     *
     * @return array
     */
    private function structRes($query, $limit, $offset)
    {
        if ($total = $query->count()) {
            $spus = $query->limit($limit)->offset($offset)->fetchAll();
            foreach ($spus as $k => $spu) {
                $spus[$k] = array_merge($spus[$k], $this->from('sku')
                                    ->where(['spu_id' => $spu['id'], 'is_delete' => 0])
                                    ->select(null)
                                    ->select('price, original_price')->fetch());
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
     * hot product info.
     *
     * @param array $params
     *
     * @return array
     */
    public function list($params)
    {
        // init page config
        $offset = (!isset($params['offset']) || $params['offset'] < 0) ? 0 : $params['offset'];
        $limit = (!isset($params['limit']) || $params['limit'] <= 0) ? \Core\Config::get('page_limit') : $params['limit'];

        $where = ['is_delete' => 0];
        // construct hot product query
        if ('hot' == $params['type']) {
            $where = array_merge($where, ['is_hot_sale' => 1]);
        } elseif ('suggest' == $params['type']) {
            $where = array_merge($where, ['is_recommd' => 1]);
        }

        // structure query
        $SPUQuery = $this->from('spu')->where($where);
        $res = $this->structRes($SPUQuery, $limit, $offset);
        // add product param
        $res['type'] = $params['type'];

        return $res;
    }

    /**
     * get product detail info.
     *
     * @param int $spuId
     *
     * @return array
     */
    public function detail($spuId)
    {
        // get spu info
        $spu = $this->from('spu')->where(['id' => $spuId, 'is_delete' => 0])->fetch();
        if (!$spu) {
            throw new \Exception("Product Don't Exists!", 404);
        }

        // get sku info
        $skus = $this->from('sku')->where(['spu_id' => $spuId, 'is_delete' => 0])->fetchAll();
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

    /**
     * get search option info.
     *
     * @param int $cateId1
     *
     * @return array
     */
    public function searchOpt($cateId1)
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
     * get search list product info.
     *
     * @param array $data
     *
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
        if (isset($data['orderBy']) && 'default' != $data['orderBy']) {
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
     * add new SPU info.
     *
     * @param array $data
     *
     * @return array
     */
    public function add($data, $files)
    {
        $this->_validate->check($data, [
            'require' => ['cate_id', 'name', 'brand', 'show_price', 'service', 'desc', 'skus', 'cover_url', 'media_id'],
            'choose' => ['is_hot_sale' => '0,1', 'is_recommd' => '0,1'],
            'default' => ['is_delete' => 0],
            'autotime' => 'create_time',
            'autoupdate' => 'update_time',
        ]);

        // insert into spu
        if ($spuId = $this->insertInto('spu')->field()->values($data)->execute()) {
            // change pic info
            if (!$this->update('media')->set(['spu_id' => $spuId])->where(['id' => $data['media_id']])->execute()) {
                throw new \Exception('Update Error!', 500);
            }

            // check desc and add default value
            $desc['value'] = $data['desc'];
            $this->_validate->check($desc, [
                'default' => ['spu_id' => $spuId, 'type' => 3],
            ]);
            // insert into spu_detail
            if (!$this->insertInto('spu_detail')->field()->values($desc)->execute()) {
                throw new \Exception('Insert Erro!', 500);
            }

            // add sku info
            $sku = new \App\Model\SKU();
            foreach ($data['skus'] as $skuInfo) {
                $sku->add($spuId, $skuInfo);
            }

            return ['spu_id' => $spuId];
        }

        throw new \Exception('Insert Erro!', 500);
    }

    /**
     * update spu info
     *
     * @param int $spuId
     * @param array $data
     * @return boolean
     */
    public function updateInfo($spuId, $data)
    {
        $this->_validate->check($data, [
            'autoupdate' => 'update_time',
        ]);

        // spu exist
        if ($this->from('spu')->where(['id' => $spuId, 'is_delete' => 0])->fetch()) {
            // add new pic
            if (isset($data['cover_url']) && !is_null($data['cover_url'])) {
                $this->_validate->check($data, [
                    'require' => ['cover_url', 'media_id']
                ]);

                // change pic info
                if (!$this->update('media')->set(['spu_id' => $spuId])->where(['id' => $data['media_id']])->execute()) {
                    // update spu
                    $this->update('spu')->field()->set($data)->where(['id' => $spuId, 'is_delete' => 0])->execute();

                    return true;
                }
            }

            throw new \Exception("Update Error!", 500);
        }

        throw new \Exception("SPU Don't Exist!", 500);
    }

    /**
     * delete spu/sku info
     *
     * @param int $spuId
     * @return boolean
     */
    public function deleteInfo($spuId)
    {
        if ($this->update('spu')->set(['is_delete' => 1])->where(['id' => $spuId, 'is_delete' => 0])->execute()) {
            if ($this->update('sku')->set(['is_delete' => 1])->where(['spu_id' => $spuId, 'is_delete' => 0])->execute()) {
                return true;
            }
        }

        throw new \Exception("Delete Error!", 500);
    }
}
