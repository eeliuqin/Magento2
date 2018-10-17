# Install the module
Extract the zip file into magento root folder(Result: app/code/Test/Downloadable)
then execute the setup upgrade command          
php -f bin/magento setup:upgrade

# How to test
Below screenshots are results in Magento 2.2.3.
## Admin
In Catalog->Products->Edit a test downloadable product->Downloadable Information, set 'Is Visible' to No.
<img width="1164" alt="is_visible_column" src="https://user-images.githubusercontent.com/16327421/47118940-f28cd300-d21d-11e8-8df8-3b12c4c87c0c.png">
and then save the product.

## Front-end
Then add that test downloadable product to cart and checkout, once the order is complete, go to Account->My Downloadble Products. The product is displaying product name only, its downloadble link is not visible.
<img width="1191" alt="frontend_link_not_visible" src="https://user-images.githubusercontent.com/16327421/47119008-2b2cac80-d21e-11e8-8a48-024cf24cc027.png">
