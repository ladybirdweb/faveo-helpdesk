<?php

/* Copyright (c) 2019 Geert Bergman (geert@scrivo.nl), highlight.php
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 3. Neither the name of "highlight.js", "highlight.php", nor the names of its
 *    contributors may be used to endorse or promote products derived from this
 *    software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace HighlightUtilities;

require_once __DIR__ . '/_internals.php';
require_once __DIR__ . '/_themeColors.php';

/**
 * Get a list of available stylesheets.
 *
 * By default, a list of filenames without the `.css` extension will be returned.
 * This can be configured with the `$filePaths` argument.
 *
 * @api
 *
 * @since 9.15.8.1
 *
 * @param bool $filePaths Return absolute paths to stylesheets instead
 *
 * @return string[]
 */
function getAvailableStyleSheets($filePaths = false)
{
    $results = array();

    $folder = getStyleSheetFolder();
    $dh = @dir($folder);

    if ($dh) {
        while (($entry = $dh->read()) !== false) {
            if (substr($entry, -4, 4) !== ".css") {
                continue;
            }

            if ($filePaths) {
                $results[] = implode(DIRECTORY_SEPARATOR, array($folder, $entry));
            } else {
                $results[] = basename($entry, ".css");
            }
        }

        $dh->close();
    }

    return $results;
}

/**
 * Get the RGB representation used for the background of a given theme as an
 * array of three numbers.
 *
 * @api
 *
 * @since 9.18.1.1
 *
 * @param string $name The stylesheet name (with or without the extension)
 *
 * @throws \DomainException when no stylesheet with this name exists
 *
 * @return float[] An array representing RGB numerical values
 */
function getThemeBackgroundColor($name)
{
    return _getThemeBackgroundColor(_getNoCssExtension($name));
}

/**
 * Get the contents of the given stylesheet.
 *
 * @api
 *
 * @since 9.15.8.1
 *
 * @param string $name The stylesheet name (with or without the extension)
 *
 * @throws \DomainException when the no stylesheet with this name exists
 *
 * @return false|string The CSS content of the stylesheet or FALSE when
 *                      the stylesheet content could be read
 */
function getStyleSheet($name)
{
    $path = getStyleSheetPath($name);

    return file_get_contents($path);
}

/**
 * Get the absolute path to the folder containing the stylesheets distributed in this package.
 *
 * @api
 *
 * @since 9.15.8.1
 *
 * @return string An absolute path to the folder
 */
function getStyleSheetFolder()
{
    $paths = array(__DIR__, '..', 'styles');

    return implode(DIRECTORY_SEPARATOR, $paths);
}

/**
 * Get the absolute path to a given stylesheet distributed in this package.
 *
 * @api
 *
 * @since 9.15.8.1
 *
 * @param string $name The stylesheet name (with or without the extension)
 *
 * @throws \DomainException when the no stylesheet with this name exists
 *
 * @return string The absolute path to the stylesheet with the given name
 */
function getStyleSheetPath($name)
{
    $name = _getNoCssExtension($name);
    $path = implode(DIRECTORY_SEPARATOR, array(getStyleSheetFolder(), $name)) . ".css";

    if (!file_exists($path)) {
        throw new \DomainException("There is no stylesheet with by the name of '$name'.");
    }

    return $path;
}

/**
 * Get the directory path for the bundled languages folder.
 *
 * @api
 *
 * @since 9.18.1.4
 *
 * @return string An absolute path to the bundled languages folder
 */
function getLanguagesFolder()
{
    return __DIR__ . '/../Highlight/languages';
}

/**
 * Get the file path for the specified bundled language definition.
 *
 * @api
 *
 * @since 9.18.1.4
 *
 * @param string $name The slug of the language to look for
 *
 * @throws \DomainException when the no definition for this language exists
 *
 * @return string
 */
function getLanguageDefinitionPath($name)
{
    $path = getLanguagesFolder() . '/' . $name . '.json';

    if (!file_exists($path)) {
        throw new \DomainException("There is no language definition for $name");
    }

    return $path;
}

/**
 * Convert the HTML generated by Highlighter and split it up into an array of lines.
 *
 * @api
 *
 * @since 9.18.1.6 `RuntimeException` and `UnexpectedValueException` can no longer be thrown.
 * @since 9.15.6.1
 *
 * @param string $html An HTML string generated by `Highlighter::highlight()`
 *
 * @return string[]|false An array of lines of code as strings. False if an error occurred in splitting up by lines
 */
function splitCodeIntoArray($html)
{
    if (trim($html) === "") {
        return array();
    }

    $queuedPrefix = '';
    $regexWorkspace = array();
    $rawLines = preg_split('/\R/u', $html);

    if ($rawLines === false) {
        return false;
    }

    foreach ($rawLines as &$rawLine) {
        // If the previous line has been marked as "open", then we'll have something
        // in our queue
        if ($queuedPrefix !== '') {
            $rawLine = $queuedPrefix . $rawLine;
            $queuedPrefix = '';
        }

        // Find how many opening `<span>` tags exist on this line
        preg_match_all('/<span[^>]*+>/u', $rawLine, $regexWorkspace);
        $openingTags = count($regexWorkspace[0]);

        // Find all of the closing `</span>` tags that exist on this line
        preg_match_all('/<\/span>/u', $rawLine, $regexWorkspace);
        $closingTags = count($regexWorkspace[0]);

        // If the number of opening tags matches the number of closing tags, then
        // we don't have any new tags that span multiple lines
        if ($openingTags === $closingTags) {
            continue;
        }

        // Find all of the complete `<span>` tags and remove them from a working
        // copy of the line. Then we'll be left with just opening tags.
        $workingLine = preg_replace('/<span[^>]*+>[^<]*+<\/span>/u', '', $rawLine);
        preg_match_all('/<span[^>]*+>/u', $workingLine, $regexWorkspace);
        $queuedPrefix = implode('', $regexWorkspace[0]);

        // Close all of the remaining open tags on this line
        $diff = str_repeat('</span>', $openingTags - $closingTags);
        $rawLine .= $diff;
    }

    return $rawLines;
}
