=== Books in WP ===
Contributors: Shed
Donate link: http://www.oncapublishing.com/projects/books-in-wp/donate
Tags: books, publishing, onix
Author URI: http://www.shedsimas.com
Plugin URI: http://www.oncapublishing.com/projects/books-in-wp
Requires at least: 3.9
Tested up to: 3.9
Stable tag: 0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The all-inclusive plugin for book publishers. An integrated system for handling books, series and contributors, plus Featured Book and other widgets.

== Description ==

Books in WP is a plugin dedicated to simplifying website management for book publishers. It adds Custom Post Types for Books, Series and Contributors. Books and Series get the custom Genre taxonomy, while Contributors get the Role taxonomy. Each post type is associated with a host of Custom Meta Fields, and more will be periodically added. All meta fields are optional.

Besides complete back-end support, Books in WP also adds simple display functions (template tags)  for each Custom Meta, like `the_isbn();` and `the_genres();`. A complete list of functions and how to use them is available in the admin panel, under Settings > Books in WP Options.

= Contributors =

Contributors serves as an umbrella term for authors, illustrators, translators, and any other contributor roles that you deem important enough to attach explicitly to a book. Contributors must be added before they can be attached to series and books.

Contributor metadata currently includes name, long bio, short bio, author photo ("Featured Image"), roles (author, illustrator, etc.) and web presence (website, Facebook and Twitter).

= Series =

Series are usually groups of books that belong together, like the Harry Potter series or the Penguin Drop Caps series. Series must be added before books can be attached to them.

Series metadata currently includes title, long description, short description, tags (same as post tags), genres (shared with books), contributors (for series where all books share contributors) and featured image.

= Books =

This is where the magic happens. Book metadata currently includes title, subtitle, book cover ("Featured Image"), long description, short description, reviews, ISBN-13, Contributors, Series and number in series, price and currency (currently supports USD, CAD and GBP), format (hardcover, ebook, etc.), dimensions and page count, publication date, stock avilability and age range.

The plugin will also automatically add a New Releases page that displays all books with a publication date in the last six months, and an Upcoming Tittles page that displays all books with publication dates in the next six months.

= Planned Features =

Among our planned features are a book preview ("look inside") feature, a dynamic "related titles" option, awards and events that can be linked to individual books, series or contributors, and a full ONIX export option. Support the project to help make these features and many others happen—and remember to send us your feedback and suggestions!

= Othe plugins =

Books in WP piggybacks on functionality provided by [WP Subtitle](http://wordpress.org/plugins/wp-subtitle/ "WP Subtitle"), [Post Type Archive Link](http://wordpress.org/plugins/post-type-archive-links/ "Post Type Archive Link") and especially [SuperCPT](https://wordpress.org/plugins/super-cpt/ "SuperCPT"). Give them your love. Some of their code was modified slightly to fit with Books in WP, so these plugins come included and you don't need to install them separately.

== Installation ==

1. Download and install the plugin through the Admin panel, or manually download the plugin package and install it on your 'plugins' directory, as you would any other plugin.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Start adding contributors, series and books!
1. Check out our display functions (template tags) in Settings > Books in WP Options and add them to your theme templates as you wish.

= Need help setting up your theme templates? =

[Get in touch](http://www.oncapublishing.com/projects/books-in-wp) with us and we will discuss the best way to assist. We can provide detailed instructions and sample templates, or we can even modify your theme for you.

== Frequently Asked Questions ==

= I'm getting 404 errors on my book/series/contributor pages. How can I fix this? =

The most common fix is to simply visit the Settings > Permalinks page in your admin panel and hit Save. For other possible causes, refer to [this article](http://wordpress.org/ "Fixing Custom Post Type 404 Errors").

= Can you help setting up the front-end display of my books, etc? =

Absolutely. Just [get in touch](http://www.oncapublishing.com/projects/books-in-wp) with us and we can discuss the options.We can provide detailed instructions and sample templates, or we can even modify your theme for you.

== Screenshots ==

1. Edit page for a Book.
2. How that book shows up on the front end. Also shows, on the right, how the book appears with the Featured Book widget.

For more screenshots and a working real-life example, please visit [the Books in WP page](http://www.oncapublishing.com/projects/books-in-wp "Onça Publishing Projects: Books in WP").

== Changelog ==

= 0.9 =
* First release.