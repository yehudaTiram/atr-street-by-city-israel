=== ATR Street By City Israel ===
Contributors: yehudaT
Donate link: https://atarimtr.co.il/
Tags: forms, city-street list, address
Requires at least: 3.0.1
Tested up to: 6.5.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a dropdown to select a street by city in Israel for any form with city-street (or city only) fields (Woocommerce,Contact form 7, Elementor etc). 

ליצירת תיבת גלילה לבחירת עיר ואז רחובות בעיר שנבחרה בטפסים. מתאים לכל טופס. מושך נתונים מעודכנים ממאגרי המידע הממשלתיים שמעדכנים ערים ורחובות על בסיס קבוע. הקוד מושך את הנתונים און ליין ולא מכביד על האתר שלך.

אפשר לראות דמו והסבר מפורט יותר כאן:
https://atarimtr.co.il/תוסף-לתצוגת-רשימת-ערים-ורחובות-בטפסי-ו/

Add a dropdown to select a street by city in Israel for any form with city-street (or city only) fields (Woocommerce,Contact form 7, Elementor etc). 

== Description ==

Simplify user experience in Israel with effortless and accurate address selection for your forms! This plugin adds a seamless dropdown menu to any form using city and street fields (or just city). Compatible with popular form builders like WooCommerce, Contact Form 7, Elementor, and more, it streamlines the process for users in Israel by allowing them to select streets based on their chosen city.

== Features ==

Enhanced User Experience: Makes filling out forms in Israel a breeze by providing an intuitive dropdown for street selection based on city.

Increased Accuracy: Reduces errors by ensuring users select valid street options corresponding to their chosen city.

Broad Compatibility: Works seamlessly with various form builders used widely on WordPress websites.

== Who should use this plugin? ==

This plugin is ideal for any WordPress website owner in Israel who uses forms to collect user information, including online stores (WooCommerce), contact forms (Contact Form 7), and website builders with form functionalities (Elementor).

== Installation ==

Upload the plugin folder to the /wp-content/plugins/ directory, or install it directly through the WordPress plugins menu.
Activate the plugin through the 'Plugins' menu in WordPress.
Configure the plugin settings as needed.

== Settings ==

1. Go to the plugin settings page from settings - ATR Street By City Israel
2. In the first 2 settings fields write the default css ID of city and street fields. These IDs (city and street) will be used in every form that has the IDs.
3. In the 3rd settings field write a comma separated page ID,city input ID,street input ID (e.g. 123,city-choice,street-choice). You can define multiple pages, each in new line. These IDs will be used in every page with the defined IDs. 
4. Make sure the forms fields IDs set correctly. 

=== Example: ===
default input ID for cities: <code>city-choice (1st field)</code>
default input ID for streets: <code>street-choice (2nd field)</code>
<strong>3rd field:</strong><pre>1112,contact-city,
2274,some-city,some-street
422,billing_city,billing_address_1</pre>

Note that in 3rd field 1st line does not add street, it is for forms that has only city field.
According to this settings, the plugin will set the dropdowns for the specified IDs in these pages and not the default.
Note that 422, here, is for woocommerce checkout page (id 422 in the example site) 

== Credit ==

Adapted in part from https://codepen.io/tombigel/pen/LYbxPRa BY Tom B https://codepen.io/tombigel

== Frequently Asked Questions ==

= Why is this plugin intended for Israel only? =

Israel gov sites provide API to cities and streets that is used with this plugin. If you have details for other countries APIs let me know and I'll try to implement it too.

= What type of forms this plugin can be used with? =

It can be used with any form as long as the city (and/or street) fields get unique css ID for each and you can set them in the plugin settings.

== Screenshots ==

1. Only city field in the form
2. The selected city is Haifa, in the streets there is a list of the streets in that city
3. The settings fields

== Changelog ==

= 1.0 =
* Start dev.



