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
            $skuInfo = $this->from('sku')->where(['id' => $skuId, 'is_delete' => 0])->fetch();
            $skuInfo['attribute'] = $this->from('sku_attr')->where(['sku_id' => $skuId, 'is_delete' => 0])->fetchAll();

            return $skuInfo;
        }

        throw new \Exception('Insert Error!', 500);
    }

    /**
     * get one sku's attr.
     *
     * @param int $skuId
     *
     * @return array|null
     */
    public function info($skuId)
    {
        if ($sku = $this->from('sku')->where(['id' => $skuId, 'is_delete' => 0])->fetch()) {
            if ($sku['attribute'] = $this->from('sku_attr')->where(['sku_id' => $skuId, 'is_delete' => 0])->fetchAll()) {
                return $sku;
            }
        }

        throw new \Exception("Don't Exists!", 404);
    }

    /**
     * update sku's info
     *
     * @param int $skuId
     * @param array $data
     * @return boolean
     */
    public function updateInfo($skuId, $data)
    {
        $this->_validate->check($data, [
            'autoupdate' => 'update_time'
        ]);

        // sku exist
        if ($this->from('sku')->where(['id' => $skuId, 'is_delete' => 0])->fetch()) {
            // update sku
            $this->update('sku')->field()->set($data)->where(['id' => $skuId, 'is_delete' => 0])->execute();
            // update sku_attr
            if (isset($data['attribute']) && !is_null($data['attribute'])) {
                $this->update('sku_attr')->field()->set($data['attribute'])->where(['sku_id' => $skuId, 'is_delete' => 0])->execute();

                return true;
            }
            throw new \Exception("Update Error!", 500);
        }

        throw new \Exception("SKU Don't Exist!", 500);
    }

    /**
     * delete sku info
     *
     * @param int $skuId
     * @return boolean
     */
    public function deleteInfo($skuId)
    {
        if ($this->update('sku')->set(['is_delete' => 1])->where(['id' => $skuId])->fetch())
        {
            return true;
        }

        throw new \Exception("Delete Error!", 500);
    }
}
