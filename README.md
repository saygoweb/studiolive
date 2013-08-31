# StudioLive #
## In a NutSHell ##
StudioLive is an HTML5 web client for the CasparCG progressional graphics Server.  [CasparCG](http://www.casparcg.com/features) is a professional graphics overlay and video playout server.  

## Features ##
* Live preview of 2 channels.
* Multiple users can use the client from any web browser.
* Define sets of Actions to be executed together (per show).
* Define any number of scenes per show.
* Conflates the data used by Flash Templates per show, making it easy to update data for multiple templates from a single UI. 
* Easy to use 'Show Time' page to operate during an event. 

## Installation Notes ##
### Windows ###
The Windows Installer should 'just work' out of the box.  It starts a web server on localhost:8080 and starts the MondoDB database server. Browse to http://localhost:8080 and you should be good to go.

However, the install is really designed for those that want to get up and running quickly on a single user system. To use StudioLive multi-user over a network you should make the following changes:

* In Config.php set USE_BOOT false
* Install mongod.exe as a service.  mongod --help will get you started.

The StudioLive system does not need to run on the same server as CasparCG.  In fact it is probably preferable that it does not.

### Linux ###
The StudioLive system is developed and tested on a Debian Wheezy system. There is no pre-built package available so for now you would have to download from the github repository and setup Apache and MongoDB yourself.