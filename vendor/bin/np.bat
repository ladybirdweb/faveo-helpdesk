@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../sly/notification-pusher/np
php "%BIN_TARGET%" %*
