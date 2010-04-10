=== Hikari Hooks Troubleshooter ===
Contributors: shidouhikari 
Donate link: http://Hikari.ws/wordpress/#donate
Tags: debug, troubleshoot, hook, action, filter, role, capability, window, draggable, wp_view_type.php, admin, drag, javascript, admin, tool, developer
Requires at least: 2.8.0
Tested up to: 2.9.2
Stable tag: 0.01.06

Creates a draggable window with informations about all functions hooked to Wordpress actions and filters.

== Description ==

**Hikari Hooks Troubleshooter** creates a *draggable window* with informations about Wordpress hooks. It lists all *hooks* (actions and filters) that have at least a function hooked to them, and for each hook there's a list of *hooked functions*, sorted by *priority*!

The window is visible only to registered users, and **you can choose who will be able to see it**, and set if it should be visible or not. It works in Wordpress page, be it frontend or admin area.

When you are in an admin page, it also shows a list of special actions related to that specific page, helping plugin developers to attach features only to special admin pages, instead of the whole admin area! A list of all *conditional tags* is also available, informing which tags return true and which ones return false, for any page you want!

The list of conditional tags and hooks is based on <a href="http://bueltge.de">Frank Bueltge</a>'s <a href="http://bueltge.de/wordpress-theme-debuggen/536/">wp_view_type.php</a>. The original code was translated from germany to english, and ported to a draggable window that can be moved inside the browser, minimized and closed.

The list of admin actions is based on <a href="http://playforward.net">Dustin Dempsey</a>'s Show Page Hooks plugin, and a few more hooks were added.


= Features =

* The plugin creates a window, that can be dragged, minimized and closed
* The window works both in website's admin panel and frontend
* You can choose who can see the window, while visitors never see it

The window presents many useful information for plugin developers:

* action and filter hooks, and functions hooked to them, sorted by the priority they are called
* all conditional tags, informing those returning *true* and those returning *false*
* all actions present in admin pages, that are specific to each page, so that we can hook features that we want to happen only on those specific pages
* actions that were run are flagged so, allowing you to know which actions are used in each specific page


== Installation ==

**Hikari Hooks Troubleshooter** requires at least *Wordpress 2.8* and *PHP5* to work.

You can use the built in installer and upgrader, or you can install the plugin manually.

1. Download the zip file, upload it to your server and extract all its content to your <code>/wp-content/plugins</code> folder. Make sure the plugin has its own folder (for exemple  <code>/wp-content/plugins/hikari-hooks/</code>).
2. Activate the plugin through the 'Plugins' menu in WordPress admin page.
3. Instantly the window will start appearing, by default only for administrators (<code>'edit_plugins'</code> capability)
4. Go to plugin admin page and you can disable and reenable the window, and choose who is able to see it


= Upgrading =

If you have to upgrade manually, simply delete <code>hikari-hooks</code> folder and follow installation steps again.


= Uninstalling =

If you go to plugins list page and deactivate the plugin, it's configs stored in database will remain stored and won't be deleted.

If you want to fully uninstall the plugin and clean up database, go to its options page and use its uninstall feature. This feature deletes all stored options, restoring them to default (which can also be used if you want defaults restored back), and then gives you direct link to securely deactive the plugin so that no database data remains stored.



== Frequently Asked Questions ==

= Will my visitors see this reporting window? Should I use the plugin only in development environments? =

Just logoff and you'll see. Unregistered users never see it, and you can choose which registered users can see it, based on Wordpress capability system.

= Great, it lists hundreds of hooks... where are all others?  =

It only shows hooks that have at least 1 function hooked to them, it seems Wordpress is not aware of a hook until something is hooked to it.

= How is the list sorted?  =

When a hook is run, functions hooked to it are called based in priority, assigned when the hooking is done; therefore, functions of a hook are listed based on this priority. The list of hooks seems to be random, I'm not sure.

= Can't you separate actions and filters in the list? Why do you show actions that were run and don't show run filters? =

Wordpress stores actions and filters in the same place, without distinguishing them. Indeed, in some codes Wordpress treats actions as filters!

The biggest difference from action to filter is that filters are required to pass at least a parameter (the content to be filtered) to functions hooked to them, and expect to receive a variable returned (the content, possibly altered by the filter), while actions aren't forced to pass parameters and never return a variable.

What really distinguish action from filter is the functions used to deal with them, which are different. And as I could learn, the only way Wordpress provides to find out if a hook is an action or a filter, is the function <code>did_action($action_tag)</code>. But even this function, it returns *true* if the hook is an action **and** was executed. If the hook is a filter, or if it's an unused action, the function returns false, so we can't even distinguish these 2 cases.

Of course I'm not a Wordpress hooks system expert, although I love it. If you know a better way to know if a hook is action or filter, and know if it was run, please contact me :)

= Can't the state of the window be saved, so that it stops opening always in the same place, and I can move it to the place I want it to open?  =

The original code couldn't. I adapted the window to work inside FireFox's extension GreaseMonkey and implemented the feature. When I ported it to use in this plugin, I had to remove the feature because didn't have time to port the feature. I plan to make the port in the future, probably using cookies.

= The window's height is absurdly large, can't you limit it and use some sliding bar?  =

I plan to enhance this draggable window, I just employed it in this project and it has some more nice feature that weren't used. When I have the time I wanna make some improvements that will make it easier to be ported and consumed by other developers, as a small lib. For now it's only an idea and I didn't wanna spend much time working on it for now.

= There's a better way to list hooks. You are missing a conditional tag or an admin action.  =

Just contact me adding a comment in the plugin page and I'll add it. Any feature that may be useful I can add too.



== Screenshots ==

1. The begining of the draggable window, with the list of admin actions that's only shown in admin pages
2. Conditional tags, here you can see in one place all tags that will return true in current page
3. Begining of the huge list of actions and filters hooks
4. The probably most popular hook, the all powerful <code>'the_content'</code> filter, with part of the many functions hooked to it
5. Another very popular hook, the <code>'wp_head'</code> action, with the flag "*ran*", pointing out it was run in that page
6. The end of the window, with wow 432 hooks! That's LARGE!!


== Changelog ==

= 0.01.06 =
* Fixed a typo that blocked the plugin to work in Unix systems.

= 0.01 =
* First public release.

== Upgrade Notice ==

= 0.01 and above =
If you have to upgrade manually, simply delete <code>hikari-hooks</code> folder and follow installation steps again.
