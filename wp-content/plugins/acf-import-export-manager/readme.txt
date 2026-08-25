### ACF Data Manager

**Plugin URI:** https://store.elsner.com/
**Description:** Export and Import ACF field data page-wise, post-wise,any cpt-wise, and group-wise.
**Version:** 1.0.0
**Author:** Elsner
**Contributors:** Elsner, Love Soni
**Author URI:** https://elsner.com/
**License:** GPL2
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html
**Text Domain:** acf-data-manager
**Domain Path:** /languages

### Description

ACF Data Manager is a WordPress plugin that allows you to easily export and import data from Advanced Custom Fields (ACF). It supports exporting and importing field data on a post-by-post, page-by-page, and even field group basis. The plugin handles data in both JSON and XML formats.

#### Features

* **Export ACF Data:** Export ACF field data from individual posts, all posts of a specific type, or all options pages.
* **Import ACF Data:** Import ACF field data to individual posts or options pages.
* **Flexible Formats:** Supports both JSON and XML file formats for export and import.
* **Overwrite Option:** Choose to overwrite existing fields during the import process.
* **Mapping Interface:** For "all posts" exports, the plugin provides a mapping table to link imported data with existing posts or create new ones.
* **User-Friendly Interface:** A simple and intuitive admin page makes it easy to manage your ACF data.
* **ACF Dependency:** The plugin requires the Advanced Custom Fields plugin to be installed and active. An admin notice will be displayed if ACF is not active.

### Installation

1.  Upload the `acf-data-manager` folder to the `/wp-content/plugins/` directory.
2.  Activate the plugin through the 'Plugins' menu in WordPress.
3.  Ensure that the Advanced Custom Fields plugin is also installed and active.

### Usage

1.  Navigate to **Tools > ACF Data Manager** in your WordPress admin dashboard.
2.  You will see two tabs: **Export** and **Import**.

#### Exporting Data

1.  Go to the **Export** tab.
2.  Select a **Post Type** from the dropdown menu, or choose **All Option Pages**.
3.  Based on your selection, choose an **Export Option** (e.g., "All Posts," "Single Post," or "Single Field Group").
4.  If you select "Single Post" or "Single Field Group," an additional dropdown will appear to let you select the specific post or field group.
5.  Choose your desired **Export Format** (JSON or XML).
6.  Click the **Export Data** button to download the file.

#### Importing Data

1.  Go to the **Import** tab.
2.  Select the **Target Post Type** from the dropdown menu.
3.  Click **Choose File** to select the JSON or XML file you wish to import.
4.  Check the "Overwrite existing ACF fields with the same name?" checkbox if you want to replace existing data.
5.  Click **Upload and Import**.
6.  If the file contains data for a single post or options page, the import will proceed directly.
7.  If the file contains multiple items, a mapping table will appear, allowing you to map source data from the file to existing posts on your site or create new posts.
8.  After configuring the mappings, click **Perform Import**.