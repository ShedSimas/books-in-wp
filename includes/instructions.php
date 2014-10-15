<?php
//Plugin instructions shown in Settings > Books in WP Options.
?>
<hr />

<h1>Theme Templates</h1>
<p>Books in WP comes with three templates: an improved Archives template (<code>archive.php</code>), plus templates for the New Releases (<code>page-new-releases.php</code>) and Upcoming Titltes (<code>page-upcoming-titles.php</code> pages. These templates can be found under <code>books-in-wp/templates</code> in your plugins directory. If you don't have these templates in your theme folder, the plugin will use its own. To change how these pages display, copy each template into your theme folder or into a child theme, and make modifications there. If you make modifications in the plugin folder, you will lose your changes with the next update.</p>
<p>Use <code>single-book.php</code>, <code>single-series.php</code> and <code>single-contributor.php</code> to change the display of sigle book, series and contributor pages, respectively. Use the template tags below to call up the data you need.</p>

<h2>Need Help?</h2>
<p><a href="http://www.oncapublishing.com/projects/books-in-wp" target="_blank">Get in touch</a> with us and we can help you set up everything you need to get your books looking great on the front end.</p>

<hr />

<h1>Template Tags</h1>

<p>Template tags are functions that you can use to display data about your website when you include them in your theme templates. All of these tags must be used within <a href="http://codex.wordpress.org/The_Loop" target="_blank">The Loop</a>, and will each take the same two optional parameters. <code>$bfr</code> is added before the data, and <code>$aft</code> is added after it. Defaults vary per tag. All empty fields are hidden. All-caps labels like "ISBN" and currency codes come wrapped with <code>&lt;span class="sc"&gt;</code> so that they can be styled in small caps in CSS.</p>

<h2>Book Template Tags</h2>
    <p><code>book_subtitle( $bfr, $aft );</code> Prints the book subtitle. Defaults: <code>$bfr = '&lt;h2&gt;'</code> and <code>$aft = '&lt;/h2&gt;'</code>.</p>
    <p><code>the_contr_names( $bfr, $aft );</code> Prints comma-separated list of contributors. Defaults: <code>$bfr = '&lt;h3&gt;'</code> and <code>$aft = '&lt;/h3&gt;'</code>.</p>
    <p><code>the_series( $bfr, $aft );</code> Prints the name of the series and the volume number. Defaults: <code>$bfr = '&lt;h4&gt;'</code> and <code>$aft = '&lt;/h4&gt;'</code>.</p>
    <p><code>the_isbn( $bfr, $aft );</code> Prints the ISBN. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_availability( $bfr, $aft );</code> Prints the stock availability. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_pub_date( $bfr, $aft );</code> Prints the publication date in the format Month DD, YYYY. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_price( $bfr, $aft );</code> Prints the price with currency code and rekated currency sumbol. If the price is set but not the currency, uses $ as the currency symbol. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_format( $bfr, $aft );</code> Prints the format. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_print_dimensions( $bfr, $aft );</code> Prints the width, height and page count. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_genres( $bfr, $aft );</code> Prints a comma-separated list of the genres. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_book_reviews( $bfr, $aft );</code> Prints the book reviews. Defaults: <code>$bfr = '&lt;br /&gt;'</code> and <code>$aft = ''</code>.</p>
    <p><code>the_contr_bios( $bfr, $aft );</code> Prints the name, photo and short bio for each contributor, with links to their pages. Defaults: <code>$bfr = '&lt;hr /&gt;'</code> and <code>$aft = ''</code>.</p>
    <p><code>books_in_same_series( $bfr, $aft );</code> Prints the title, cover and short description of all other books in the same series. Features a jQuery show/hide toggle. Defaults: <code>$bfr = '&lt;hr /&gt;'</code> and <code>$aft = ''</code>.</p>
    <p><code>the_availability( $bfr, $aft );</code> Prints the stock availability. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>

<h2>Contributor Template Tags</h2>
    <p><code>the_roles( $bfr, $aft );</code> Prints a comma-separated list. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_contr_website( $bfr, $aft );</code> Prints a link to the contributor's website. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_contr_fb( $bfr, $aft );</code> Prints a link to the contributor's Facebook page. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>the_contr_twitter( $bfr, $aft );</code> Prints a link to the contributor's Twitter profile. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>books_by_author( $bfr, $aft );</code> Prints the name, cover and short description of all books by the contributor. Features a jQuery show/hide toggle. Defaults: <code>$bfr = '&lt;hr /&gt;'</code> and <code>$aft = ''</code>.</p>

<h2>Series Template Tags</h2>
    <p><code>the_contr_names( $bfr, $aft );</code> Prints comma-separated list of contributors. Defaults: <code>$bfr = '&lt;h3&gt;'</code> and <code>$aft = '&lt;/h3&gt;'</code>.</p>
    <p><code>the_genres( $bfr, $aft );</code> Prints a comma-separated list of the genres. Defaults: <code>$bfr = '&lt;li&gt;'</code> and <code>$aft = '&lt;/li&gt;'</code>.</p>
    <p><code>books_in_series( $bfr, $aft );</code> Prints the title, cover and short description of all books in the series. Defaults: <code>$bfr = '&lt;hr /&gt;'</code> and <code>$aft = ''</code>.</p>
    <p><code>books_in_series_list( $bfr, $aft );</code> Prints a comma-separated list of the titles in this series. Defaults: <code>$bfr = '&lt;p&gt;'</code> and <code>$aft = '&lt;/p&gt;'</code>.</p>

<h2>Default WordPress Template Tags</h2>
    <p>Some Books in WP fields piggyback on default WordPress fields. Refer to the WordPress Codex for full documentation of these functions. You may also use any other default <a href="http://codex.wordpress.org/Template_Tags" target="_blank">template tag</a>.</p>
    <p><a href="http://codex.wordpress.org/Function_Reference/the_title" target="_blank"><code>the_title();</code></a> Prints the book or series title or contributor name.</p>
    <p><a href="http://codex.wordpress.org/Function_Reference/the_post_thumbnail" target="_blank"><code>the_post_thumbnail();</code></a> Prints the book cover, series featured image, or contributor photo.</p>
    <p><a href="http://codex.wordpress.org/Function_Reference/the_excerpt" target="_blank"><code>the_excerpt();</code></a> Prints the book or series short description or the contributor short bio.</p>
    <p><a href="http://codex.wordpress.org/Function_Reference/the_content" target="_blank"><code>the_content();</code></a> Prints the book or series long description or the contributor long bio.</p>


<?php
