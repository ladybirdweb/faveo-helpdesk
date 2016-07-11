4.3.0 / 2015-09-30
==================

* Add support for Flows (https://developers.podio.com/doc/flows)


4.2.0 / 2015-07-02
==================

* Add `update_reference` and `count` to `PodioTask`
* Create `PodioVoting`
* Add low memory file fetch
* Verify TLS certificates
* Minor bug fixes


4.1.0 / 2015-06-16
==================

* Fix `PodioFile` `get_raw` concatenation
* Fix user model `mail` return value
* Add votes property and support for options when getting item
* Add missing properties to Comment model
* Add description to space model
* Make upload function compatible with `PHP 5.6`
* Add activation method for platform
* Add search method for platform
* Add method for org bootstrap for platform


4.0.2 / 2014-09-29
==================

* Minor bugfixes


4.0.1 / 2014-07-17
==================

* Minor bugfixes
* Make `authenticate_with_password` actually work
* Support image downloads at different sizes


4.0.0 / 2014-05-14
==================

* Introduced PodioCollection to make it easier to work with collections. Removed field and related methods from * PodioItem and PodioApp objects. Use the new array access interface instead.
* Made Podio*Itemfield objects more intuitive to work with
* Unit tests added for PodioCollection (and subclasses), PodioObject and Podio*ItemField classes
* Improved debugging options and added Kint for debugging
* Bug fixed: Handle GET/DELETE urls with options properly.
* Made __attributes and __properties private properties of PodioObject instances to underline that they shouldn’t be used


3.0.0 / 2014-01-31
==================

* Add options to bulk delete


2.0.0 / 2012-08-28
==================

* ¯\_(ツ)_/¯
