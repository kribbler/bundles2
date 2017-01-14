* 2.5.6 29.05.2014
    * Fixed: Minor issues with new Jigoshop 1.9's JWOS.
    * Improved: Remove licence validator - require Jigoshop 1.9 at least.
* 2.5.5 12.04.2014
    * Added: Support for new Jigoshop script and styles API.
* 2.5.4 31.03.2014
    * Move to Jigoshop.com
* 2.5.3.1 25.02.2014
    * Fixed: Pricing strategy accessing through private field.
* 2.5.3 20.02.2014
    * Fixed: Removed invalid check for cart items to be valid.
* 2.5.2 16.02.2014
    * Added: Ability to change pricing strategy.
    * Added: Global variable with Customer Discounts instance.
* 2.5.1 13.02.2014
    * Fixed: Categories of variable products are now fetched with categories of parent product.
* 2.5 10.02.2014
    * Added: "Give away" discount.
* 2.4.5.1 05.02.2014
    * Fixed: Additional fix for variable and base products.
* 2.4.5 29.01.2014
    * Fixed: Discounts are checked against variable and base products.
* 2.4.4 15.12.2013
    * Improved: Working with variable products.
* 2.4.3 10.12.2013
    * Fixed: Integration with Jigoshop Multi Currencies.
* 2.4.2 08.11.2013
    * Fixed: Division by zero when using cart threshold with fixed price.
* 2.4.1 30.10.2013
    * Fixed: Cart threshold discount
* 2.4 10.09.2013
    * Added: New discount - cart value - useful when you want some customers to get everything they want for a fixed price.
* 2.3.1 30.05.2013
    * Fixed: Product quantity discount when applied to all products
* 2.3 16.05.2013
    * Fixed: Refactored code responsible for calculating quantities and discounts
    * Added: Support for Jigoshop Product Addons plugin
* 2.2.5 26.04.2013
    * Added: Full polish translation
    * Added: New discount type - From X products
* 2.2.4.1 17.04.2013
    * Fixed: Display of variable product price when discount is applied.
* 2.2.4 15.04.2013
    * Fixed: Product selecting in each_x_products and product_quantity.
* 2.2.3 27.03.2013
    * Fixed: Correct working of "first purchase discount".
    * Fixed: Non-translatable text "Your price".
* 2.2.2.1 20.03.2013
    * Added: Polish translation.
    * Added: Hide "You save" text in product list view.
    * Added: Possibility to hide first purchase discounts from not logged in users.
    * Fixed: Incorrect domain in one translation.
    * Fixed: Displaying "You save" text with 0 savings.
* 2.2.2 20.03.2013
    * Added: Possibility to display "You save" in cart, product and checkout views.
    * Added: Separate tab for Customer Discounts options.
    * Added: Default frontend style for displaying savings.
* 2.2.1 14.03.2013
    * Fixed: Proper installing onto tab, so Jigoshop translations work.
* 2.2 15.02.2013
    * Added: First purchase discount option.
    * Added: Cart threshold discount.
    * Added: Apply the highest discount when free products are forbidden.
    * Fixed: Notice in Groups plugin support.
* 2.1.6 11.12.2012
    * Fixed warnings when displaying shop list.
* 2.1.5 08.12.2012
    * Added support for Jigoshop Multi Currencies plugin.
    * Added support for variable products.
* 2.1.4 24.11.2012
    * Fixed displaying discounted price in the shop and product view.
* 2.1.3 21.11.2012
    * Fixed incorrect calculation of product price when coupon is used.
* 2.1.2 14.11.2012
    * Fixed incorrect handling of coupons and discounts options.
* 2.1.1 10.11.2012
    * Fixed bug causing floating point differences between discounts to be incorrectly sorted.
* 2.1 09.11.2012
    * Added new type of discount: "Each X products".
    * Added option to define behaviour when coupons are used and product will be for free with discount.
    * Added option to allow creation 100% discounts (free products).
* 2.0.5 29.10.2012
    * Fixed notice when Groups plugin is used and there is no user logged in.
* 2.0.4 26.10.2012
    * Fixed warnings when Groups plugin used.
* 2.0.3
    * Added option to enable discounts when coupon is used.
    * Fixed bug causing warning when all discounts are in trash.
* 2.0.2
    * Fixed discounts calculating on Checkout when using JavaScript.
* 2.0.1
    * Fixed adding discounts for products on sale.
    * Fixed discount sorting fatal error.
* 2.0
    * Rewritten plugin from the beginning.
    * Dropped support for Jigoshop older than 1.3.
    * Removed priority - order_id support - instead plugin checks which discount is the best for the moment.
* 1.1.3
    * Changed discount value field type to text - fixes bug causing discount to disappear in Chrome and Opera.
* 1.1.2
    * Fixed some problems with discounts priorities.
    * Fixed problem with "Fixed price" and "Percentage price".
* 1.1.1
    * Added possibility to create "Product quantity" and "Products in cart" discounts with fixed price and percentage discount.
* 1.1
    * Added possibility to create many discount of types "Product quantity" and "Products in cart" for the same product.
    * Fixed warning when Groups plugin is installed.
* 1.0.3
    * Fixed checking if Jigoshop is active.
    * Fixed loading plugin translations.
* 1.0.2
    * Fixed bug causing plugin not to activate when Jigoshop is activated later by Wordpress than the plugin.
* 1.0.1
    * Fixed fatal error when Jigoshop is being updated.
* 1.0
    * Initial version
