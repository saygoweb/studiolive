# StudioLive Change Log#
## 0.10.1 ##

- Added a screen snapshot to the previews on the scene page.  A screenshot can be captured and assigned as a thumbnail to the show and / or scene.

## 0.9.12 ##

- Added a caspar connected indicator to the top right.
- Refactored the breadcrumbs to use a breadcrumbService.

## 0.9.10 ##

- Added a scene select dropdown on the scene page.
- Media files for images, templates, and video can now be selected by a drop down, with the drop down options being obtained from the Caspar server.
- Updated the listview component so that paging, and count per page work on all lists (shows and scenes).
- Fixed a bug where the preview channel selectors where changing together.

## 0.9.9 ##

- Fixed a bug in the windows installer where the Caspar Communications was not working. Added php_sockets.dll and php.ini change.

## 0.9.8 ##

- Add application settings for previews.
- Add master preview enable in Config.php which disables the preview div entirely.

## 0.9.6 ##

- Added application settings for camera setup.
- Initial work on customizable settings for preview.
- Fixed bug in executeAction where only Flash Templates were working, but not other actions.

## 0.9.5 ##

- Added in / out preview to Show | Actions tab.
- The 'New Action' button now uses an initially hidden form in a similar manner to other controls.
- Add in / out / and refresh (update) buttons on Scene | Data tab.

## 0.9.4 ##

- Added Preview Controls. Play, Stop, and Channel selection.
- Add breadcrumbs to top of screen for easier navigation.
- Changed new show and new scene links to buttons in the control bar.

### Preview ###
The previews are played on udp://239.7.7.1:12345 (top preview) and udp://239.7.7.1:12346 (bottom preview). Any network connected player like VLC can view these on udp://@239.7.7.1:12345 and udp://@239.7.7.1:12346 respectively.

## 0.8.10 ##
Initial release
