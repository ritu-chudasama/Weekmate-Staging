### ACF Data Manager

A WordPress plugin for exporting and importing Advanced Custom Fields data.

**Plugin URI:** https://store.elsner.com/
**Author:** Elsner
**Author URI:** https://elsner.com/
**Version:** 1.0.0
**License:** GPL2 or later
**Requires at least:** 4.0
**Tested up to:** 6.8W
**Requires PHP:** 7.0

---

### Description

The ACF Data Manager is a lightweight and powerful WordPress plugin designed to simplify the management of your Advanced Custom Fields (ACF) data. It provides a user-friendly interface to effortlessly export and import field data for individual posts, pages, or even entire sets of field group. This tool is essential for developers and site administrators who need to migrate content, create backups, or manage large volumes of ACF data with precision.

The plugin supports both JSON and XML formats for maximum flexibility and compatibility with different workflows.

#### Key Features

* **Effortless Export:** Export ACF field data from a single post, an entire post type, or all options pages with just a few clicks.
* **Seamless Import:** Import data back into your site, with the ability to overwrite existing fields or create new entries.
* **Flexible File Formats:** Work with your preferred data format, as the plugin supports both JSON and XML.
* **Intuitive Mapping:** For bulk imports, a clear mapping interface helps you match incoming data to existing posts, ensuring accuracy and control.
* **ACF Integration:** Built specifically for the Advanced Custom Fields plugin, providing a seamless and integrated experience.

---

### Installation

1.  Download the plugin from the WordPress repository or the provided source.
2.  Unzip the folder and upload the `acf-data-manager` directory to the `/wp-content/plugins/` directory of your WordPress installation.
3.  Activate the plugin via the **Plugins** menu in your WordPress dashboard.
4.  Ensure that the **Advanced Custom Fields** plugin is installed and activated. An admin notice will remind you if it is not.

---

### How to Use

Once activated, you can access the plugin's features by navigating to **Tools > ACF Data Manager** in your WordPress admin menu.

#### 1. Exporting Data

1.  Select the **Export** tab.
2.  Choose the **Post Type** or **All Option Pages** you wish to export data from.
3.  Refine your export with options for **Single Post** or **All Posts**.
4.  Select your desired **Export Format** (JSON or XML).
5.  Click the **Export Data** button to download the file to your computer.

#### 2. Importing Data

1.  Select the **Import** tab.
2.  Choose the **Target Post Type** for your import.
3.  Click **Choose File** to select the JSON or XML file from your computer.
4.  Optionally, check the box to **overwrite existing fields** with the same name.
5.  Click **Upload and Import**. If you are importing multiple items, you will be presented with a mapping table to verify the import process before finalizing.

---

### Screenshots

_As I am a text-based model, I cannot provide images. However, here are descriptions of the screens you would see:_

1.  **Export Tab:** A clean interface with dropdowns for selecting post type, export options, and file format.
2.  **Import Tab:** A simple form to upload a file, with a checkbox for overwriting data.
3.  **Mapping Table:** A grid-like interface that appears for bulk imports, showing a clear connection between the data in your file and the posts on your site.

---

### Changelog

**1.0.0 (YYYY-MM-DD)**
* Initial release.
* Added core functionality for exporting and importing ACF data.
* Implemented support for JSON and XML formats.
* Introduced data mapping for bulk imports.
* Created a clean and easy-to-use admin interface.