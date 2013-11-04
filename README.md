# Magento Facebook Friend Auction #

### Description ###

A useless Magento module that reads your friendlists using Facebook's PHP SDK.  The module will create categories from your friendlists and products from your friends.

## Instructions ##
1. Copy the app/ and lib/ directories into the root of your Magento installation.
2. Edit app/code/local/InfiniteApps/FbFriendAuction/Model/Facebook.php lines 22 and 23 with valid Facebook appid and app secrect
3. Log into the MAgento backend and goto InfiniteApps->Friend Auction
4. Click the Connect to Facebook button.
5. Click the Create new Products button.

## Limitations & Known Bugs ##
* Clicking the Create New Products button more than once will create double categories.  Unexpected behaviour will result by doing so.
* In order to prevent script timeout and memory limit errors, the Facebook friendlists and friends request are limited to 10.  Therefore, it will only be possible to create 100 products inside of 10 categories.
 
## Todo ##
* Cache the friendlist and friends to a database table.  This will allow product and category creation in smaller batches.  Processing this data using asyncronous calls will allow us to recovery from errors and display progress output to the user.
* Check if categories already exist before creating them.
* Download facebook profile pictures, and save them to the products.
* Correctly save the facebook bio to magento product description, this is probably not saving due incorrect to access permissions.