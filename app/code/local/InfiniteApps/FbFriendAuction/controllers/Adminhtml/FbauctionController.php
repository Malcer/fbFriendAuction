<?php
/**
 * Created by PhpStorm.
 * User: tariq
 * Date: 11/3/13
 * Time: 1:20 PM
 */

class InfiniteApps_FbFriendAuction_Adminhtml_FbauctionController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Facebook Friend Auction'));

        $this->loadLayout()
            ->_setActiveMenu('infiniteapps/fbfriendauction')
            ->renderLayout();

    }

    public function logoutAction()
    {
        Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->logout();
        $this->_redirect('*/fbauction/index');

        return;
    }

    public function createProductsAction()
    {
        $friendlist = Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getFriendlists();

        if (!empty($friendlist['data']))
        {
            foreach( $friendlist['data'] as $list )
            {
                Mage::helper('infiniteapps_fbfriendauction')->createCategoryFromFacebookData( $list );
            }
        }

        $this->_redirect('*/fbauction/index');

        return;
    }

} 