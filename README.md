# StudioLive #
## In a NutSHell ##
StudioLive is an HTML5 web client for the CasparCG professional graphics Server.  [CasparCG](http://www.casparcg.com/features) is a professional graphics overlay and video playout server.

StudioLive uses AngularJS for the front end and PHP with MongoDB on the backend.  Its an open source project, pull requests are welcome.  

## Features ##
* Live preview of a configurable number of channels.
* Multiple users can use the client from any web browser.
* Define sets of Actions to be executed together (per show).
* Screen Shot feature for capturing thumbnails to represent shows and scenes graphically.
* Conflates the data used by Flash Templates per show, making it easy to update data for multiple templates from a single UI. 
* Easy to use 'Show Time' page to operate during a live event or studio recording. 
* Define any number of scenes per show.

## What's New as of 1.0 ##

- Everything.

See the [Change Log](https://github.com/saygoweb/studiolive/blob/master/CHANGELOG.md) for more details.

## Installation Notes ##
The latest Windows version is [available here](https://drive.google.com/folderview?id=0B1aEHU7j2cRhdTVOdHp0VjdRUkE&usp=sharing).

**Minimum Requirements:** Windows 7 64 bit.  Home Premium is known to work well.

### Windows Quick Start ###
* Just installed? Keep reading then [Click to Start StudioLive](http://localhost:8080/).
* For the video preview to work you must install the [VLC (Video Lan)](http://www.videolan.org/vlc/index.html) media player on the client system. 

### Configuration ###
For now the configuration is not built in to the application.  You have to edit www_root/Config.php using a text editor. You will most likely want to set CASPAR\_HOST to the hostname of your Caspar server.  If running on the same machine as the server you can leave this set to 'localhost'.

### Windows ###
The Windows Installer should 'just work' out of the box.  It starts a web server on localhost:8080 and starts the MondoDB database server. Browse to http://localhost:8080 and you should be good to go.

However, the install is really designed for those that want to get up and running quickly on a single user system. To use StudioLive multi-user over a network you should make the following changes:

* In Config.php set USE_BOOT false
* Install mongod.exe as a service.  mongod --help will get you started.

The StudioLive system does not need to run on the same server as CasparCG.  In fact it is probably preferable that it does not.

### Linux ###
The StudioLive system is developed and tested on a Debian Wheezy system. There is no pre-built package available so for now you would have to download from the github repository and setup Apache and MongoDB yourself.

## Status ##
StudioLive has a stable release 1.0.

Future development plans are discussed on the Caspar Forum.

* Checkout the [Trello things to do list](https://trello.com/b/dChvuzOw/saygo-studiolive) for more details.

### How to Help ###
* Report issues you find in our [GitHub Issue Tracker](https://github.com/saygoweb/studiolive/issues).  Please report with as much detail as you can.  Simply saying "It doesn't work" will gain you sympathy, but not a lot else.
* Join the discussion on the [CasparCG Forum](http://casparcg.com/forum/viewtopic.php?f=3&t=1646).  Your thoughts and ideas are welcome.
* Want do contribute code?  Go right ahead, fork the project on [GitHub](https://github.com/saygoweb/studiolive), pull requests are welcome.
