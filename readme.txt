=== SW - Portfolio CPT ===
Contributors: seniorswp, dazzadev
Tags: custom-post-type, portfolio, rest-api, graphql
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Custom Post Type for Portfolio projects with taxonomies, custom fields, gallery, and optional WPGraphQL support.

== Description ==

Adds a Portfolio Custom Post Type with:

* 6 taxonomies: Category, Client, Sector, Location, Tech Stack, Services (all support multiple selection)
* Client taxonomy with image/logo field
* Custom fields: objective, client testimonial, project URL
* Project screenshot gallery with sortable images
* Custom admin columns with thumbnail preview
* REST API support (built-in)
* WPGraphQL support (optional)

== Frequently Asked Questions ==

= Do I need WPGraphQL? =

No. The plugin works with WordPress REST API by default. WPGraphQL support is optional and activates automatically when the WPGraphQL plugin is detected.

= How do I access portfolio projects via API? =

REST API: `/wp-json/wp/v2/portfolio`
GraphQL: `swPortfolios` query (requires WPGraphQL plugin)

= How do I add a client image? =

Go to Portfolio > Clients, add or edit a client, and use the "Upload Image" button to assign an image/logo.

== Changelog ==

= 1.0.0 =
* Initial release
