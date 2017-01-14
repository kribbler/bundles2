/*
Plugin Name: Jigoshop UPS Shipping Method
Author: Sixty-One Designs
Support: support@sixtyonedesigns.com
*/

The Jigoshop UPS Shipping module allows you to pull in real-time UPS shipping rates to your Jigoshop. In order to use 
this extension, you need to have a UPS Account, ups.com username and password and a UPS Rates API key. Each of
these items can be obtained from UPS through the ups.com website. 

#Installation:
Installation is handled just like any other Wordpress Plugin. 
1. In your Wordpress admin section, go to the Plugins tab. 
2. Click Add New, and upload the zip file. 
3. Once the file is uploaded, activate the newly created Jigoshop UPS Shipping Method plugin. 

Thats it for installation, now you just need to setup the plugin from your Jigoshop Settings page. 

#Setup
Once the plugin has been installed, go to the Jigoshop Settings page to configure the UPS shipping method. The UPS method
is available in the Shipping tab on the Jigoshop Settings page. Once configured, the UPS shipping extension will 
only work for those products that have weights assigned to them. 
 
1. Enter in the following UPS credentials on the setup page to enable UPS rates
	a. UPS Username - This is your login name for http://www.ups.com. If you don't have an account on ups.com,
	   		  you'll need to register for one. Registration is free.

	b. UPS Password - This is your password for http://www.ups.com. If you don't have an account on ups.com,
	 		  you'll need to register for one. Registration is free.

	c. UPS API Key  - This is your API key. You will need to acquire one of these from ups. This is free and can 
			  be obtained through the ups website. 

	d. UPS Shipper Number - This is your UPS account number and not the same as your username. A shipper number is 
				free and is linked to your API key. This can be obtained through the ups website as well. 

	e. Source Postal Code - This is your postal code, or the poastal code where your shipments will be originating
				if they are different 

	f. UPS Method -  Check the boxes of the available UPS shipping methods that you'd like to offer on your website. 
			 The list of available methods is based on the UPS services in your Base Country/Region. 
	
	g. Handling Fee - If you'd like to charge an additional handling fee to your UPS shipments, add that value here. 
			  If not, leave the field blank. 

After you've filled in those fields and enabled the shipping method, your website should be ready to receive real-time UPS 
rates. If you're not receiving rates, please check to make sure that your UPS API key, username, password and account are 
entered correctly and active. If you need help determining whether your account details are good and/or active, you can 
contact UPS or a UPS Account Representative. 

  

Changelog
= 1.0.1 = 
* Patch - fix int rounding on weight and weight calculation on items with qty > 1 
= 1.0 =
* Initial release