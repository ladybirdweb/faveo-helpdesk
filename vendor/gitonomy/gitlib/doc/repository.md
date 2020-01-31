Repository methods
==================

Creating a *Repository* object is possible, providing a *path* argument
to the constructor:

```php
$repository = new Repository('/path/to/repo');
```

Repository options
------------------

The constructor of Repository takes an additional parameter: `$options`.
This parameter can be used used to tune behavior of library.

Available options are:

-   **debug** (default: true): Enables exception when edge cases are met
-   **environment\_variables**: (default: none) An array of environment
    variables to be set in sub-process
-   **logger**: (default: none) Logger to use for reporting of execution
    (a `Psr\Log\LoggerInterface`)
-   **command**: (default: `git`) Specify command to execute to run git
-   **working\_dir**: If you are using multiple working directories,
    this option is for you

An example:

```php
$repository = new Repository('/path/to/repo', [
    'debug'  => true,
    'logger' => new Monolog\Logger(),
]);
```

Test if a repository is bare
----------------------------

On a *Repository* object, you can call method *isBare* to test if your
repository is bare or not:

```php
$repository->isBare();
```

Compute size of a repository
----------------------------

To know how much size a repository is using on your drive, you can use
`getSize` method on a *Repository* object.

> **warning**
>
> This command was only tested with linux.

The returned size is in kilobytes:

```php
$size = $repository->getSize();

echo 'Your repository size is '.$size.'KB';
```

Access HEAD
-----------

`HEAD` represents in git the version you are working on (in working
tree). Your `HEAD` can be attached (using a reference) or detached
(using a commit).

```php
$head = $repository->getHead(); // Commit or Reference
$head = $repository->getHeadCommit(); // Commit

if ($repository->isHeadDetached()) {
    echo 'Sorry man'.PHP_EOL;
}
```

Options for repository
----------------------

### Logger

If you are developing, you may appreciate to have a logger inside
repository, telling you every executed command.

You call method `setLogger` as an option on repository creation:

```php
$repository->setLogger(new Monolog\Logger('repository'));

$repository->run('fetch', ['--all']);
```

You can also specify as an option on repository creation:

```php
$logger = new MonologLogger('repository');
$repository = new Repository('/path/foo', ['logger' => $logger]);
$repository->run('fetch', ['--all']);
```

This will output:

```
info run command: fetch "--all"
debug last command (fetch) duration: 23.24ms
debug last command (fetch) return code: 0
debug last command (fetch) output: Fetching origin
```

### Disable debug-mode

Gitlib throws an exception when something seems wrong. If a `git` command exits
with a non-zero code, then execution will be stopped, and a `RuntimeException`
will be thrown. If you want to prevent this, set the `debug` option to` false`.
This will make `Repository` log errors and return empty data instead of
throwing exceptions. 

```php
$repository = new Repository('/tmp/foo', ['debug' => false, 'logger' => $logger]);
```

> **note**
>
> If you plan to disable debug, you should rely on the logger to keep a trace
> of the failing cases.

### Specify git command to use

You can pass the option `command` to specify which command to use to run git
calls. If you have a git binary located somewhere else, use this option to
specify to gitlib path to your git binary:

```php
$repository = new Gitonomy\Git\Repository('/tmp/foo', ['command' => '/home/alice/bin/git']); 
```

### Environment variables

It is possible to send environment variables to the `git` commands.

```php
$repository = new Gitonomy\Git\Repository('/tmp/foo', ['environment_variables' => ['GIT_']])
```
