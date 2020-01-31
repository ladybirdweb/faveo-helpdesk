Computing diff
==============

Even if git is a diff-less storage engine, it's possible to compute
them.

To compute a diff in git, you need to specify a *revision*. This
revision can be a commit (*2bc7a8*) or a range (*2bc7a8..ff4c21b*).

For more informations about git revisions: *man gitrevisions*.

When you have decided the revision you want and have your *Repository*
object, you can call the *getDiff* method on the repository:

```php
$diff = $repository->getDiff('master@{2 days ago}..master');
```

You can also access it from a *Log* object:

```php
$log  = $repository->getLog('master@{2 days ago}..master');
$diff = $log->getDiff();
```

Iterating a diff
----------------

When you have a *Diff* object, you can iterate over files using method
*getFiles()*. This method returns a list of *File* objects, who
represents the modifications for a single file.

```php
$files = $diff->getFiles();
echo sprintf('%s files modified%s', count($files), PHP_EOL);

foreach ($files as $fileDiff) {
    echo sprintf('Old name: (%s) %s%s', $fileDiff->getOldMode(), $fileDiff->getOldName(), PHP_EOL);
    echo sprintf('New name: (%s) %s%s', $fileDiff->getNewMode(), $fileDiff->getNewName(), PHP_EOL);
}
```

The File object
---------------

Here is an exhaustive list of the *File* class methods:

```php
$file->getOldName();
$file->getNewName();
$file->getOldDiff();
$file->getNewDiff();

$file->isCreation();
$file->isDeletion();
$file->isModification();

$file->isRename();
$file->isChangeMode();

$file->getAdditions(); // Number of added lines
$file->getDeletions(); // Number of deleted lines

$file->isBinary(); // Binary files have no "lines"

$file->getChanges(); // See next chapter
```

The FileChange object
---------------------

> **note**
>
> This part of API is not very clean, very consistent. If you have any
> idea or suggestion on how to enhance this, your comment would be
> appreciated.

A *File* object is composed of many changes. For each of those changes,
a *FileChange* object is associated.

To access changes from a file, use the *getChanges* method:

```php
$changes = $file->getChanges();
foreach ($changes as $change) {
    foreach ($lines as $data) {
        list ($type, $line) = $data;
        if ($type === FileChange::LINE_CONTEXT) {
            echo ' '.$line.PHP_EOL;
        } elseif ($type === FileChange::LINE_ADD) {
            echo '+'.$line.PHP_EOL;
        } else {
            echo '-'.$line.PHP_EOL;
        }
    }
}
```

To get line numbers, use the range methods:

```php
echo sprintf('Previously from line %s to %s%s', $change->getOldRangeStart(), $change->getOldRangeEnd(), PHP_EOL);
echo sprintf('Now from line %s to %s%s', $change->getNewRangeStart(), $change->getNewRangeEnd(), PHP_EOL);
```
