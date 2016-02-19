<?php

return [
    // Interval defines the time in minutes between two run method calls - in other words, the time between the Cron route or command will be called
    'runInterval' => 1,
    // Should the Laravel integrated logger handle the logging
    'laravelLogging' => true,
    // Enable or disable database logging
    'databaseLogging' => true,
    // Enable or disable logging error jobs only
    'logOnlyErrorJobsToDatabase' => false,
    // Delte old database entries after how many hours - if this value is set to 0, no entries will be deleted
    'deleteDatabaseEntriesAfter' => 240,
    // Prevent job overlapping - if Cron is still running it could not be started a second time
    'preventOverlapping' => true,
    // Enable or disable the check if the current Cron run is in time
    'inTimeCheck' => true,
    // Cron application key for securing the integrated Cron run route - if the value is empty, the route is disabled
    'cronKey' => 'Sv9zmTTmLVODDEkI1NrRnAbfBJIPH2nf',
];
