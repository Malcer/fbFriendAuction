<?php
/**
 * Created by PhpStorm.
 * User: tariq
 * Date: 11/3/13
 * Time: 2:12 PM
 */

require_once( Mage::getBaseDir('lib') . '/facebook/facebook.php' );

class InfiniteApps_FBFriendAuction_Model_Facebook extends Mage_Core_Model_Abstract
{

    const ACCESS_SCOPE = 'read_friendlists';

    private $_fbInstance;

    public function _construct()
    {

        $config = array(
            'appId' => '',
            'secret' => '',
        );

        $this->_fbInstance = new Facebook($config);

    }

    public function getLoginUrl()
    {
       return $this->_fbInstance->getLoginUrl(array(
           'display' => 'popup',
           'scope'=>self::ACCESS_SCOPE
       ));
    }

    public function getLogoutUrl( $nextUrl )
    {
        $config = array('next'=>Mage::helper("adminhtml")->getUrl('adminhtml/fbauction/logout'));

        return $this->_fbInstance->getLogoutUrl($config);
    }

    public function getUser()
    {
        return $this->_fbInstance->getUser();
    }

    public function getUserProfile( )
    {
        $uid = $this->_fbInstance->getUser();

        $_profile = false;

        if ($uid)
        {
            try
            {
                $_profile = $this->_fbInstance->api('/me');
            }
            catch (FacebookApiException $e)
            {
                /*
                 * our access token is most likely invalid; reset our things
                 */
                $uid = null;
                $this->_fbInstance->setAccessToken(null);
            }
        }

        return $_profile;
    }

    public function setAccessToken( $token )
    {
        $this->_fbInstance->setAccessToken( $token );
    }

    public function getFriendlists()
    {
        $content = $this->_fbInstance->api('/me/friendlists', array(
            'fields'=>'name,id,members.limit(10).fields(pic_small,name)',
            'limit' => '10'
        ));

        return $content;
    }

    public function getFriends()
    {
        $content = $this->_fbInstance->api('/me/friends');

        return $content;
    }

    public function getFriendInfo( $id )
    {
        $content = $this->_fbInstance->api("me/friends/$id", array('fields'=>'bio'));

        return $content;
    }


    public function logout()
    {
        $this->_fbInstance->destroySession();
    }



} 