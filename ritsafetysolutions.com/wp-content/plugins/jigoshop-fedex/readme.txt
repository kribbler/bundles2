/*
Plugin Name: Jigoshop FedEx Shipping Method
*/

The Jigoshop FedEx Shipping module allows you to pull in real-time FedEx shipping rates to your Jigoshop. In order to use 
this extension, you need to have the following FedEx credentials:
	1. A FedEx Account 
	2. A FedEx Meter Number 
	3. A FedEx Web Services Access Key
	4. A FedEx Web Services Password. 
These items can either be obtained through the FedEx website or with the aid of your FedEx Account Representative. The Account number and meter
number should appear on your billing statements. To obtain the web services credentials, you can go to http://www.fedex.com/us/developer/index.html
and login with your information. 

Once logged in, click on "Technical Resources">"Web Services for Shipping". Once on this page, click the "Move to Production" link and at the
bottom of that page you will see an "Obtain Production Key" link. If you click this icon, you'll start the process to get production API access. 
For the Registration for FedEx Web Services Production Access, use the following settings:
1. Do you intend to resell your software? - No
2.Check "FedEx Web Services for Shipping"
3. Please indicate whether you are developing your FedEx integration solution as a Corporate Developer or as a Consultant.- Consultant

Click the "Continue" button. On the next screen, click the "I Accept" button for the License Agreement. After you accept the License Agreement, 
fill in the Contact Info for your active FedEx account and then press continue. After that screen, the Developer Info should be pre-populated. 
Press continue on that screen as well and then confirm your request. Once submitted you should receive your credentials to the production FedEx Web Service. 

#Installation:
Installation is handled just like any other Wordpress Plugin. 
1. In your Wordpress admin section, go to the Plugins tab. 
2. Click Add New, and upload the zip file. 
3. Once the file is uploaded, activate the newly created Jigoshop FedEx Shipping Method plugin. 

Thats it for installation, now you just need to setup the plugin from your Jigoshop Settings page. 

#Setup
Once the plugin has been installed, go to the Jigoshop Settings page to configure the FedEx shipping method. The FedEx method
is available in the Shipping tab on the Jigoshop Settings page. Once configured, the FedEx shipping extension will 
only work for those products that have weights assigned to them. 
 
1. Enter in the following FedEx credentials on the setup page to enable FedEx rates
	a. FedEx Webservices Mode: Production

	a. FedEx Access Key: This is your Access Key that you will receive from FedEx once your request for the production Web Services access has 
			  been granted.	

	b. FedEx Password: This is your Password that you will receive from FedEx once your request for the production Web Services access has 
			       been granted.

	c. FedEx Meter Number: This is the FedEx meter number associated with your account. This number should be available from your billing statement, 
			       in your FedEx account, or from your FedEx Account Representative. 

	d. FedEx Account Number: This is your active FedEx account number. 

	e. FedEx Source Postal Code: This is your postal code, or the poastal code where your shipments will be originating
				     if they are different 

	f. FedEx Methods: Check the boxes of the available FedEx shipping methods that you'd like to offer on your website. 
			  The list of available methods is based on the FedEx services in your Base Country/Region. 
	
	g. Handling Fee - If you'd like to charge an additional handling fee to your FedEx shipments, add that value here. 
			  If not, leave the field blank. 

After you've filled in those fields and enabled the shipping method, your website should be ready to receive real-time FedEx
rates. If you're not receiving rates, please check to make sure that your FedEx access key, password, account and meter number are 
entered correctly and active. If you need help determining whether your account details are good and/or active, you can 
contact FedEx or your FedEx Account Representative. 

