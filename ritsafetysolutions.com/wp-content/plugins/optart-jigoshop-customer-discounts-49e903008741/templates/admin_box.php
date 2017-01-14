<?php
wp_nonce_field('jigo_cd_save_meta', 'jigo_cd_meta_nonce');
// disable the permalink slug display
?>
<style type="text/css">
#edit-slug-box {
    display: none
}
</style>
<div id="discount_options" class="panel jigoshop_options_panel">
    <div class="options_group">
<?php
// Discount Types
$args = array(
    'id' => 'type',
    'label' => __('Discount Type', 'jigoshop_customer_discounts'),
    'options' => $this->getDiscountTypes()
);
echo Jigoshop_Forms::select($args);

// Quantity
$args = array(
    'id' => 'quantity',
    'label' => __('Quantity', 'jigoshop_customer_discounts'),
    'type' => 'number',
    'desc' => __('Enter a value, i.e. 20', 'jigoshop_customer_discounts'),
    'placeholder' => '0'
);
echo Jigoshop_Forms::input($args);

// Value
$args = array(
    'id' => 'value',
    'label' => __('Discount Value', 'jigoshop_customer_discounts'),
    'type' => 'text',
    'desc' => __('Enter a value, i.e. 9.99 or 20%.', 'jigoshop_customer_discounts').(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free', 'no') == 'yes' ? ' '.__('For free please enter 100%.', 'jigoshop_customer_discounts') : ''),
    'placeholder' => '0.00'
);
echo Jigoshop_Forms::input($args);
?>
</div>
<div class="options_group">
<?php
// Include product ID's
$selected = implode(',', (array)get_post_meta($post->ID, 'products', true));

$args = array(
    'id'            => 'products',
    'type'          => 'hidden',        /* use hidden input type for Select2 custom data loading */
    'class'         => 'long',
    'label'         => __('Products', 'jigoshop_customer_discounts'),
    'desc'          => __('Control which products this coupon can apply to.','jigoshop_customer_discounts'),
    'value'         => $selected
);
echo Jigoshop_Forms::input($args);

// Categories
$categories = array();
foreach (get_terms('product_cat', array('hide_empty' => false)) as $category)
{
    $categories[$category->term_id] = $category->name;
}

$args = array(
    'id' => 'categories',
    'label' => __('Categories', 'jigoshop_customer_discounts'),
    'desc' => __('Control which product categories this discount can apply to.', 'jigoshop_customer_discounts'),
    'multiple' => true,
    'placeholder' => __('Any category', 'jigoshop_customer_discounts'),
    'class' => 'select long',
    'options' => $categories
);
echo Jigoshop_Forms::select($args);

// Users
$users = $this->getUsers();
$args = array(
    'id' => 'users',
    'label' => __('Users', 'jigoshop_customer_discounts'),
    'desc' => __('Control which user this discount can apply to.', 'jigoshop_customer_discounts'),
    'multiple' => true,
    'placeholder' => __('Any user', 'jigoshop_customer_discounts'),
    'class' => 'select long',
    'options' => $users
);
echo Jigoshop_Forms::select($args);

// Roles
$groups = $this->getRoles();
$args = array(
    'id' => 'groups',
    'label' => __('Groups', 'jigoshop_customer_discounts'),
    'desc' => __('Control which group this discount can apply to.', 'jigoshop_customer_discounts'),
    'multiple' => true,
    'placeholder' => __('Any group', 'jigoshop_customer_discounts'),
    'class' => 'select long',
    'options' => $groups
);

echo Jigoshop_Forms::select($args);

// First purchase discount?
	$args = array(
		'id' => 'first_purchase',
		'label' => __('Only first purchase?', 'jigoshop_customer_discounts'),
		'desc' => __('Select to allow the discount for the first purchase that client has made in your shop.', 'jigoshop_customer_discounts')
	);
	echo Jigoshop_Forms::checkbox($args);
?>
</div>
<script type="text/javascript">
		var quantity_help = {
        'product_quantity':"<?php _e('Quantity of selected product in cart to apply discount, i.e. 5.', 'jigoshop_customer_discounts'); ?>",
        'cart_quantity':"<?php _e('Number of products in cart to apply discount, i.e. 5.', 'jigoshop_customer_discounts'); ?>",
        'each_x_products':"<?php _e('Which product has a discount, i.e. every third is 3 in this field.', 'jigoshop_customer_discounts'); ?>",
				'from_x_products':"<?php _e('After how many products you want to give the discount, i.e. third, fourth and so on product discounted is 2 in this field.', 'jigoshop_customer_discounts'); ?>",
        'cart_threshold':"<?php _e('Minimum cart value to apply discount.', 'jigoshop_customer_discounts'); ?>",
        'give_away':"<?php _e('Number of items to give away. Next ones will be in normal price.', 'jigoshop_customer_discounts'); ?>"
		}
</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var type_val;
        $('#type').change(function() {
            type_val = $(this).find('option:selected').val();
            if($.inArray(type_val, ['cart_quantity', 'cart_threshold', 'product_quantity', 'each_x_products', 'from_x_products', 'give_away']) > -1)
            {
		            $('.quantity_field > span.description').html(quantity_help[type_val]);
                $('.quantity_field').show();
            }
            else
            {
                $('.quantity_field').hide()
            }
        }).change();
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        // allow searching of products to use on a discount
        jQuery("#products").select2({
            minimumInputLength: 3,
            multiple: true,
            closeOnSelect: true,
            placeholder: "<?php _e('Any product', 'jigoshop_customer_discounts'); ?>",
            ajax: {
                url: "<?php echo (!is_ssl()) ? str_replace('https', 'http', admin_url('admin-ajax.php')) : admin_url('admin-ajax.php'); ?>",
                dataType: 'json',
                quietMillis: 100,
                data: function(term, page) {
                    return {
                        term:       term,
                        action:     'jigoshop_json_search_products_and_variations',
                        security:   '<?php echo wp_create_nonce( "search-products" ); ?>'
                    };
                },
                results: function( data, page ) {
                    return { results: data };
                }
            },
            initSelection: function( element, callback ) {
                var stuff = {
                    action:     'jigoshop_json_search_products_and_variations',
                    security:   '<?php echo wp_create_nonce( "search-products" ); ?>',
                    term:       element.val()
                };
                var data = [];
                jQuery.ajax({
                    type: 		'GET',
                    url:        "<?php echo (!is_ssl()) ? str_replace('https', 'http', admin_url('admin-ajax.php')) : admin_url('admin-ajax.php'); ?>",
                    dataType: 	"json",
                    data: 		stuff,
                    success: 	function( result ) {
                        callback( result );
                    }
                });
            }
        });
    });
</script>
</div>