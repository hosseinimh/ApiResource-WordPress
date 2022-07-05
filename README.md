
# API Resource REST-API WordPress plugin, widget, shortcode and 'Entries Details' page 

A simple project fetches data from REST API resource and show with plugin.

## Plugin

Plugin name is `Api Resource`.

Key classes are in `includes` directory.

### Widget

Widget name is `API Resource Widget`.

The plugin fetches the list of books by `GET` request from API endpoint.
The widget, then shows the number of books.

### shortcode

shortcode name is `[api_resource_entries]`.

It shows books names as unodered list (`ul`).

### Entries Details page
The page title is `Entries details`.

It shows full list of books including image, description, extra info, category title, tags.






## Installation

After installing `Api Resource` plugin in WordPress, add `API Resource Widget`.

Set `Api url` to REST API resource.

```bash
  http://127.0.0.1:8000/api
```
    
## Key functions

All key functions are in `includes` directory.

### ApiResource.php

The file that defines the core plugin class.

- getRestApiUrl()

    Returns the url of REST API resource.

- loadDependencies()

    Loads the required dependencies for this plugin.

- createWidget()

    Creates widget for REST API resource.

- createShortCode()

    Creates shortcode for REST API resource.

- setEntriesPage()

    Creates or updates detailed page for entries fetched from REST API resource.

- createEntriesContent()

    Creates content with entries fetched from REST API resource.

### ApiResourceFetcher.php

Fetch books and categories from REST API.

- fetchBooks()

    Fetches list of books from REST API.

- fetch($url)

    Fetches data from REST API.

### ApiResourceWidget.php

Register all actions and filters for the plugin.

- widget($args, $instance)
    
    Front-end display of widget.

- form($instance)

    Back-end widget form.

- update($newInstance, $oldInstance)

    Sanitizes widget form values as they are saved.
