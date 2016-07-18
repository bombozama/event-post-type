## Event Post Type

Custom post type implementation for events management

### Description

* Registers the event post type
* Registers an event custom taxonomy
* Registers a few metaboxes (Start date, End date, Location)
* Adds the featured image to the admin column display
* Adds the event count to the admin dashboard

### Customization

There are a couple filters for the event post type and taxonomy arguments in this plugin.

If you want to change this post type from "team" to something different ("products","resources",etc.) you'll want to 
update a couple file and class names throughout the plugin- but the main modifications will be in the 
"class-post-type-registrations.php" file.  This is where the post type and taxonomy are registered.

### Requirements

* WordPress 3.8 or higher

### Credits

Edited from the [Devin Price](http://www.wptheming.com/) [Team Post Type](https://github.com/devinsays/team-post-type) boilerplate plugin.