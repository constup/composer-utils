# `ComposerDirectoryUtil`

## Description

Utilities for working with directories related to Composer or directories defined in
`composer.json` file.

## Dependencies

### `string` : `projectRootDir`

Destination project's root directory. Note that a root directory is considered a 
directory where `composer.json` file is located.

### `object` : `composerJsonObject`

Object representation of `composer.json`.

An example of an object like this is a result of 
`json_decode(file_get_contents($composerJsonFilePath));`

## Methods

### `getSourceDirectories(): string[]`

Return an array of all absolute directory paths listed in `autoload > psr-4` and
`autoload-dev > psr-4` sections of `composer.json`.

For a PHP project, these should be all directories where developer-written code can be.
