<?php
/**
 * Template Name: Distrubutor Page
 */

get_header(); ?>
<?php 
	extract(etheme_get_page_sidebar());
?>

<style type="text/css">
.product_category { 
	width:160px; float:left; display:block; margin: 0px 50px 60px 0px; padding:0px;  
}
.product_category .product-title { 
	width:160px; display:block; text-align:center;  margin: 0px 0px 5px 0px; padding:0px;  
}
.product_category img { 
	display:block; width:160px;  border: 1px solid #ccc;
}
</style>

<div class="container">
	<div class="row-fluid">
		<div class="span12 a-center">
			<div class="products-page distrubutor-products-page row-fluid" >
           
             
            
            <h1>FIRE RESCUE PRODUCTS</h1> 
            <div style="clear:both; width:810px; height:1px; margin:0; padding:0; display:block;"></div> 
            <div style=" margin: 0px 0px 0px 0px; font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#b00000; ">Distributors</div><br />
              
				<?php   					 
				while ( have_posts() ) : the_post(); 
					the_content(); 
				endwhile; 
				wp_reset_query(); 
				?> <br />
                <hr /> 
                <form  name="search_distributor" id="search_distributor" method="post" action="" onsubmit="txt_search_distributor.value=(txt_search_distributor.value=='To find distributor type Company, Sales Person, State' ? '' : txt_search_distributor.value)">
                	<input  type="text" name="txt_search_distributor" id="txt_search_distributor" value="To find distributor type Company, Sales Person, State" onfocus="this.value=''" onblur="this.value=(this.value !='' ? this.value : 'To find distributor type Company, Sales Person, State')" />
                    <input type="submit" name="submit" id="submit" value="Search"/>
                </form>
                
				<?php  
				$iii = 1;
				if (isset($_POST['txt_search_distributor']))
					$txt_search_distributor = $_POST['txt_search_distributor'];
				if ( $txt_search_distributor != '' ) {
					query_posts( 's='.$txt_search_distributor.'&post_type=distributor&order=ASC' );
				} else {
					query_posts( 'showposts=-1&post_type=distributor&order=ASC' ); 						 
				}
				while ( have_posts() ) : the_post(); 
					if( $iii > 5 ) {$iii = 1; echo '<div class="clear"></div>';}
				?>
                <div class="distributor"> 					 
					<?php the_content(); ?>
                </div>
                <?php $iii++;
				endwhile; 
				wp_reset_query(); 
				?> 
           
              <div class="clear"></div><br />
 	</div>
</div>
</div>
</div>
<?php get_footer(); ?>