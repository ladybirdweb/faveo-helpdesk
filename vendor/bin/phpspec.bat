@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpspec/phpspec/bin/phpspec
php "%BIN_TARGET%" %*
