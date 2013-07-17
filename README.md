## NateCMS

This is a new kind of CMS

* Designed for the end developer in mind
* Allows for clean and cool configurations
* Also is pretty good with calendar based dynamic styling

Please note the configuration of your webserver

* Server root should be pointed to public_html
* Server specific configuration is contained within the /libinc dir

[bign8](http://nathanjwoods.com)

### Development list
- [x-ish] Rename tables to have underscores after web (ie: web_block, web_vfs, web_template)
- [x] Change webScripts edit to an enum('yes', 'no') type
- [x] Rename webContent location column to locID
- [x] Implement load order in page.php near "get dynamic includes"
- [x] Implement new database class + convert to PDO
- [x] Implement custom file extensions
- [x] Link logo and remove header text
- [x-ish] Move login/edit/close/logout buttons to magic bar that is out of the way (login preferably hidden and magically revealed)
- [ ] Implement dbError page (sent error emails, aditional config)
- [ ] Rewrite so db actions is all sqlite friendly
- [ ] Admin note - when new directory is created, automatically generate index file for new directory
- [ ] Move /login /logout and other pages generated in php to database generated pages
- [ ] Implement /db404 page so that there are no db queries on that page
- [ ] Handle errors when adding content block
- [ ] Store all site settings in a options table or something special
- [ ] Edit - disable redundant saves on webHistory feature
- [ ] Edit - add content / many TODO's json_format see http://www.happycode.info/php-json-response/
- [ ] Edit - work on webHistory feature
- [ ] Implement auto nav -> looking for index or use parentID in database
- [ ] self Install feature?