# Inquiry Wordpress Plugin

- Contributors: Andre Verona
- Requires at least: 4.7
- Tested up to: 5.5
- Requires PHP: 7.2 or later
- License: GPLv2 or later
- License URI: https://www.gnu.org/licenses/gpl-2.0.html

Inquiry adds inquiry form and show inquiry lists in the pages. 

## Description 

Inquiry uses to add inquiry form and show inquiry list in the pages using shortcodes.

Shortcode list
1. inquiry_form shortcode
	- description: It is to show inquiry form.
	- example: [hw_inquiry_form title="This is my inquiry form" /]
	- attributes:
	- title: The title of the inquiry form.

2. inquiry_list shortcode
	- description: It is to show inquiry list. Please note it shows inquiry list only when logged-in user is administrator.
	- example: [hw_inquiry_list title="This is the title of inquiry list" per_page="10" /]
	- attributes:
	- title: The title of the inquiry list.
	- per_page: The numbers to show inquiries on page. It is used for pagination.