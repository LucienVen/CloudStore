<?php

namespace App\Model;

class SKU extends \Core\Model
{
    /**
     * add new SKU info.
     *
     * @param int   $spuId
     * @param array $data
     *
     * @return array
     */
    public function add($spuId, $data)
    {
        $this->_validate->check($data, [
            'require' => ['price', 'original_price', 'stock'],
            'default' => ['spu_id' => $spuId, 'is_delete' => 0],
            'autotime' => 'create_time',
            'autoupdate' => 'update_time',
        ]);

        // insert into sku
        if ($skuId = $this->insertInto('sku')->field()->values($data)->execute()) {
            // has attribute
            if (isset($data['attribute']) && !is_null($data['attribute'])) {
                // check sku_attr
                $attribute = $data['attribute'];
                $this->_validate->check($attribute, [
                    'require' => ['attr', 'opt'],
                    'default' => ['sku_id' => $skuId],
                ]);
                // insert into sku_attr
                if (!$this->insertInto('sku_attr')->field()->values($attribute)->execute()) {
                    throw new \Exception('Insert Error!', 500);
                }
            }

            // get sku detail info
            $skuInfo = $this->from('sku')->where(['id' => $skuId])->fetch();
            $skuInfo['attribute'] = $this->from('sku_attr')->where(['sku_id' => $skuId])->fetchAll();

            return $skuInfo;
        }

        throw new \Exception('Insert Error!', 500);
    }
}
