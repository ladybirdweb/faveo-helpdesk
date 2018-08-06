@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../unisharp/laravel-filemanager/bin/debug
php "%BIN_TARGET%" %*
