=== FileMaker API Wrapper ===
Contributors: iandunn
Donate link: ???
Tags: filemaker, api
Requires at least: ???
Tested up to: 3.3.2
Stable tag: 0.1a
License: GPL2

**NOTE: This project isn't in a stable state and may not work for you out of the box. I started it for a client, but then the project shifted directions and I haven't had time to finish it on my own time.**

Provides a clean, consistent and efficient way for WordPress plugins and themes to connect to FileMaker via [the official API](http://www.filemaker.com/support/technologies/php.html) or [FX.PHP](http://www.iviking.org/FX.php/).

@todo complete this file


== Description ==

????
used when you're writing a custom plugin to interact w/ filemaker
install this plugin instead of including the API into your project folder

note: apis themselves aren't bundled with the plugin because of licensing issues, see the installation page for details on adding them

note: doesn't provide a common interface between the two APIs, just a common way to instantiate them. after instantiating, you interact when them using their native methods just like normal

**Advantages Over Including APIs Directly**

* singleston so only one instance across all plugins that use it
* because it's a plugin, you can check that it's active when setting up activation requirements for other plugins that need to use it
* poor man's monitoring solution for sites that depend on FM server being accessible. plugin e-mails you when it can't connect to server, so you know that it's down.
* keeps your plugins folder smaller/less cluttered
* dont have to update api code in multiple plugins


Basic instructions are on [the Installation page](http://wordpress.org/extend/plugins/???/installation/). Check [the FAQ](http://wordpress.org/extend/plugins/???/faq/) for help.

== Installation ==

**Automatic Installation**

1. Login to your blog and go to the Plugins page.
2. Click on the 'Add New' button.
3. Search for '???'.
4. Click 'Install now'.
5. Enter your FTP or FTPS username and password. If you don't know it, you can ask your web host for it.
6. Click 'Activate plugin'.
8. Follow the Basic Usage instructions below

**Manual Installation**

1. Download the plugin and un-zip it.
2. Upload the *???* folder to your *wp-content/plugins/* directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Follow the Basic Usage instructions below

**Manual Upgrading:**

1. Just re-upload the plugin folder to the wp-content/plugins directory to overwrite the old files.

**Basic Usage:**

1. After activating the plugin, go to the '???' page under the Settings menu.

install api files in includes folder
	official api bundled w/ server pakcage. ask your dba for a coyp
		includes/filemaker.php
		includes/filemaker/error.php and others
	download fx.php from website
		includes/fx.php
		includes/fx/[extra files] ???

choose api radio button [or detect automatically?]

2. Add connection info, check status field for error messages
Add the following constants to your wp-config.php file and fill in the values for your server:


define( FILEMAKER_IP,			'' );
define( FILEMAKER_PORT,			'' );
define( FILEMAKER_USERNAME,		'' );
define( FILEMAKER_ERROR_EMAILS,	'' );	// comma-separated list - e.g., foo@gmail.com,bar@example.net,foobar@example.com
define( FILEMAKER_PASSWORD,		'' );

// wasn't there a constant for db name?

then use as normal
@todo provide examples here from both apis


== Frequently Asked Questions ==

= Why should I use this instead of just requiring the API files in my project directly? =
See [the **Features** list](http://wordpress.org/extend/plugins/???/installation/).



== Screenshots ==
1. The options page.


== Changelog ==

= 0.1 =
* Initial release


== Upgrade Notice ==

= 0.1 =
Initial release.