Revision
========

To get a revision from a *Repository* object:

```php
$revision = $repository->getRevision('master@{2 days ago}');
```

Getting the log
---------------

You can access a *Log* object starting from a revision using the
*getLog* method. This method takes two parameters: *offset* and *limit*:

```php
// Returns 100 lasts commits
$log = $revision->getLog(null, 100);
```

Resolve a revision
------------------

To resolve a revision to a commit:

```php
$commit = $revision->getCommit();
```
