Jigoshop Authorize Pro
======================

### Installation

1. Upload the plugin folder to the '/wp-content/plugins/' directory
2. Activate plugin through the 'Plugins' menu in WordPress
3. Go to 'Jigoshop/Manage Licenses' to enter license key for your plugin

### Notes

CONNECTION METHODS

The Authorize.net PRO payment gateway for Jigoshop has a variety of connection methods that can be used to submit credit card payments from customers to your Authorize Merchant Account.  These methods are:

AIM -- Advanced Integration Method - SSL *is* required and offers maximum security and full PCI compliance.  Customers stay on your Shop server to enter their credit card information.
SIM -- Server Integration Method - No SSL required.  Customers are transfered to Authorize.net secured SSL servers to enter credit card Information.
DPM -- Direct Post Method - No SSL required.  Uses unique transaction "fingerprint" for security.  Customers stay on your Server, but credit card information is posted directly *from* the customer to the secured Authorize servers bypassing the Shop server.  (Please note: an SSL certificate is still highly recommended in order to display "https" in the browser URL and promote customer confidence).

If you have the Jigoshop General Tab Setting for "Force SSL on Checkout" enabled, then the AIM method will *always* be used.  Your server must have a valid SSL installation and certificate for this method and this offers you the means of keeping your customers on your site at the Checkout where they can securely enter their credit card information.

If you do not have SSL available on your server then either of the other 2 connection methods can be selected in the Authorize.net PRO Payment Gateway settings.

TEST MODE

If this setting is enabled, then you must have an Authorize.net developer account and all transactions will be sent to the Authorize.net testing servers:
https://developer.authorize.net/testaccount

You will need to enter *these* 'API Login ID' and 'Transaction Key' settings into the Jigoshop Payment Gateways settings panel for Authorize.net PRO as they are different from your actual Authorize Merchant Account.

When you are ready to go 'LIVE' and process actual transactions, then you will need to *reset* these 2 settings for the gateway to your actual Authorize Merchant Account values and disable the 'Test Mode' setting.

DEBUG LOGGING

When enabled in the Authorize.net PRO gateway settings, all transactions are logged into a file on your server within the Authorize.net PRO plugin folder, within a 'log' folder.  Ensure this file has 'write' permissions for your server.  Use this to help troubleshoot any errors and connection problems.


### Where to find your Authorize.net Credentials

To setup your Authorize.net PRO payment gateway you will need to enter your 'API Login ID' and 'Transaction Key'.
1.  Login to your Authorize.net account  (or developer account for Test Mode)
2.  Click on the Account tab on the top navigation menu
3.  Under the Security Settings area, click on "API Login ID and Transaction Key"
4.  Your API Login ID will be displayed.  Copy this value to your Jigoshop Payment Gateways settings panel for Authorize.net PRO
5.  To get the Transaction Key answer the Secret Question (you should check the box next to "Disable Old Transaction Key(s)")
6.  Press Submit and your new Transaction Key will be displayed.  Copy this value to your Jigoshop Payment Gateways settings panel for Authorize.net PRO
7.  Save the settings.

If you are using the SIM or DPM connection methods, you may also require the 'MD5 Hash' setting although it's optional:
1.  Login to your Authorize.net account  (or developer account for Test Mode)
2.  Click on the Account tab on the top navigation
3.  Under the Security Settings area, click on "MD5 Hash"
4.  Enter a new hash phrase.  This can be anything you like as it's similar to a password.
5.  Submit this and enter it into your Jigoshop Payment Gateways settings panel for Authorize.net PRO
6.  Save the settings.
