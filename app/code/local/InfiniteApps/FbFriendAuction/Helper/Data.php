<?php
/**
 * Created by PhpStorm.
 * User: tariq
 * Date: 11/3/13
 * Time: 1:14 PM
 */ 
class InfiniteApps_FbFriendAuction_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * createCategoryFromFacebookData
     *
     * @author tariq chaudhry <tariqachaudhry@gmx.com>
     *
     * @param $data
     * @return mixed
     */
    public function createCategoryFromFacebookData ( $data )
    {

           $category = Mage::getModel('catalog/category');
           $category->setStoreId(0);

            $category->setData(array(
                'name' => $data['name'],
                'path' => '1/2',
                'description' => $data['name'],
                'is_active' => 1,
                'is_anchor' => 1,
            ));

            try
            {
                $category->save();
            }
            catch(Exception $e)
            {
                var_dump($e);
                exit;
            }

            $members = $data['members'];
            if( !empty($members['data']) )
            {
                $this->createProductsFromMemberList($members['data'], $category->getId());
            }


        return $category->getId();
    }

    public function createProductsFromMemberList ( $list, $category_id )
    {
        foreach ($list as $_item)
        {
            $this->createProduct($_item['name'], $_item['id'], $_item['bio'], $category_id);
        }
    }

    public function createProduct( $name, $sku, $desc, $cat_id)
    {
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);

        /*
         * Create new product or if it already exists add the category
         */
        if (!$product)
        {
            $product = Mage::getModel('catalog/product');

            $product->setData(array(
                'name' => $name,
                'sku' => $sku,
                'price' => '1.00',
                'type_id' => 'simple',
                'attribute_set_id' => 4,
                'category_ids' => array($cat_id),
                'website_ids' => array(1),
                'description' =>$desc,
                'short_description' => $desc,
                'weight' => '1.0',
                'visibility' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                'status' => 1,
                'stock_data' => array (
                    'is_in_stock' => 1,
                    'qty' => 1,
                )
            ));
        }
        else
        {
            $cats = $product->getCategoryIds();
            $cats[] = $cat_id;
            $product->setCategoryIds($cats);

        }
        try
        {
            $product->save();
        }
        catch (Exception $e)
        {
            var_dump($e);
            return false;
        }

        return $product->getId();
    }


}