
# API Resource REST-API plugin, Widget, shortcode and entries details page in WordPress

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
    