<?php

class InfiniteApps_FbFriendAuction_Block_Fbauction extends Mage_Adminhtml_Block_Template
{

    public function isFbLoggedIn()
    {
        return (Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getUser() != null);
    }

    /**
     * getFbLoginButtonUrl
     *
     * @author tariq chaudhry <tariqachaudhry@gmx.com>
     *
     * @return mixed
     */
    public function getFbLoginButtonUrl()
    {
        if ($this->isFbLoggedIn())
        {
            return Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getLogoutUrl();
        }
        else
        {
            return Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getLoginUrl();
        }
    }

    public function getCreateProductsUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/fbauction/createProducts');
    }

    /**
     * getName
     *
     * @author tariq chaudhry <tariqachaudhry@gmx.com>
     *
     * @return string
     */
    public function getName()
    {
        if ($this->isFbLoggedIn())
        {
            $profile = Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getUserProfile();

            return "{$profile['first_name']} {$profile['last_name']}";
        }
    }

    public function getFriendlists()
    {
        $lists = Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getFriendlists();

        if (!empty($lists['data']))
        {
            return $lists['data'];
        }
        else
        {
            return false;
        }

    }

    public function _debug()
    {
        if ($this->isFbLoggedIn())
        {
            return (Mage::getSingleton('infiniteapps_fbfriendauction/facebook')->getFriendlists());
        }
    }



}