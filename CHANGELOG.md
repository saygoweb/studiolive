# StudioLive Change Log#
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
