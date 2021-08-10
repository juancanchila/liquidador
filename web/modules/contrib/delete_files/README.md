# Delete Files

Delete files easily.

## INSTALLATION

1. Install the module in your usual way (it has no non-core dependencies), and enable it at yoursite/admin/modules
2. Set permissions to view & delete files at yoursite/admin/people/permissions
3. Go to the Delete Files tab at yoursite/admin/content/delete, which shows the writable files in your site's public//: directory
4. Delete files
5. Profit

If a file you've deleted's managed by Drupal, this module replaces it with a new empty file to head off potential problems with dangling file references. Be careful though: don't delete what you don't understand. (Which is not a bad rule to live by.)

## CONFIGURATION

The number of files shown per page (so far) can be configured at yoursite/admin/config/media/delete_files

## ALTERNATIVES TO USING THIS MODULE

- Delete files via the file system (if you have access to that)
- Use the [views bulk operations module][vbo] to add a delete action to /admin/content/files - only works for managed files, and not always then
- Try the [file delete module][fdo], which has since come out, it looks to again only work for managed files (and yet again, not always even then)
- Cry

[fdo]: https://www.drupal.org/project/file_delete
[vbo]: https://www.drupal.org/project/views_bulk_operations
