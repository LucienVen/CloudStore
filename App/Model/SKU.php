<?php

namespace App\Model;

class SKU extends \Core\Model
{
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
        $SPUQuery = $this->from('spu')->where($where);
        if ($total = $SPUQuery->count()) {
            // fetch by limit
            $spus = $SPUQuery->limit($limit)->offset($offset)->fetchAll();
            foreach ($spus as $k => $spu) {
                $spus[$k] = array_merge($spus[$k], $this->from()
                                    ->where(['spu_id' => $spu['id']])
                                    ->select(null)
                                    ->select('price')->fetch());
            }
            // struct the result array
            $res['type'] = $params['type'];
            $res['offset'] = $offset;
            $res['limit'] = $limit;
            $res['total'] = $total;
            $res['products'] = $spus;

            return $res;
        }

        throw new \Exception("Don't have any Data!", 404);
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
