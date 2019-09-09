# `ComposerJsonFileUtil`

## Description

Class for finding and fetching `composer.json` files.

## Dependencies

None.

## Methods

### `findComposerJSON(string $startDirectory): ?string`

#### Parameters

- `string` : `startDirectory` - A directory where you want to start searching for 
`composer.json` from. The method will search the directory tree upwards up until the root.

#### Result

Absolute path of the directory containing a parent `composer.json` (relative to the 
`startDirectory`). If `composer.json` is not found, **`null`** is returned.

---

### `fetchComposerJSONObject(string $composerJsonFilePath): object`

#### Parameters

- `string` : `composerJsonFilePath` - Absolute file path of a `composer.json` file.

#### Result

Returns the contents of `composer.json` object in an object form. Sub-nodes aree then 
accessible as object's properties.

A special case are nodes which have `-` sign in them (ex.: `autoload-dev`), since you can't directly access an 
object's property with the sign in it. To access the property, store the name of the node
in a constant and access by using the constant (ex. `self::$AUTOLOAD_DEV`).

---

### `findAndFetchComposerJson(string $startDirectory): object`

#### Parameters

- `string` : `startDirectory` - A directory where you want to start searching for 
`composer.json` from. The method will search the directory tree upwards up until the root.

#### Result

This method simply uses `fetchComposerJSON` after `findComposerJSON`.