=== LH Paragraph Ids ===
Contributors: shawfactor
Donate link: http://lhero.org/plugins/lh-paragraph-ids/
Tags: paragraphs, links, html, html5, fragment, id, indieweb, rdf
Requires at least: 3.0
Tested up to: 4.2
Stable tag: trunk

LH Paragraph Ids is a WordPress plugin that adds paragraph level ids elements to singular posts and post types.

== Description ==

LH Paragraph Level IDs plugin adds an ‘id’ attribute to each paragraph tag in a blog post, giving the author and readers additional functionality.

So for example, <p> becomes <p id="para1234-5">.

There is also an optional feature to add a link to the paragraph at the end of the post, like this. #

These additions allow anyone to link directly to that paragraph in the post. This is useful for long tracts of text and is also useful for rdf and semantics (in that these technologies often require identification of parts of a page).

== Installation ==

Install using WordPress:

1. Log in and go to *Plugins* and click on *Add New*.
2. Search for *LH Paragraph Ids* and hit the *Install Now* link in the results. WordPress will install it.
3. From the Plugin Management page in WordPress, activate the *Lh Paragraph Ids* plugin.
4. Go to *Settings* -> *LH Paragraph Ids* in the WordPress menu and specify the settings.

Install manually:

1. Download the plugin zip file and unzip it.
2. Upload the plugin contents into your WordPress installation*s plugin directory on the server. The plugin*s .php files, readme.txt and subfolders should be installed in the *wp-content/plugins/lh-tools/* directory.
3. From the Plugin Management page in Wordpress, activate the *Lh Paragraph Ids* plugin.
4.  Go to *Settings* -> *LH Paragraph Ids* in the Wordpress menu and specify the settings.

== Changelog ==

**0.01 July 29, 2014**  
Initial release.

**0.02 April 29, 2015**  
Only filter content on front end

**1.0 July 13, 2015**  
Object oriented code