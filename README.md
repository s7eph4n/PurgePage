# PurgePage

[![Latest Stable Version](https://poser.pugx.org/mediawiki/purge-page/v/stable)](https://packagist.org/packages/mediawiki/purge-page)
[![Packagist download count](https://poser.pugx.org/mediawiki/purge-page/downloads)](https://packagist.org/packages/mediawiki/purge-page)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/s7eph4n/PurgePage/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/s7eph4n/PurgePage/?branch=master)

The [PurgePage][mw-purge-page] extension provides the `#purge` parser function
to MediaWiki. This parser function allows to trigger an update to a parser
functions whenever the page where this function is used is updated.

## Example usage

On page `Foo` add the following parser function call to the wikitext:
```
{{#purge:Bar}}
```

Now every time `Foo` is purged (e.g. every time it is edited and saved) `Bar`
will also be updated.

This can be useful, when the content of `Bar` depends on `Foo`, e.g. when using
a [SemanticMediawiki][SMW] query on `Bar` that contains data from `Foo` in the
results.

## Requirements

- PHP 5.4 or later
- MediaWiki 1.26 or later

## Installation

The recommended way to install this extension is by using [Composer][composer].
Just add the following to the MediaWiki `composer.local.json` file and run
`php composer.phar update mediawiki/purge-page` from the MediaWiki
installation directory.

```json
{
	"require": {
		"mediawiki/purge-page": "~1.0"
	}
}
```

(Alternatively you can download a tar ball or zip file from
[GitHub](https://github.com/s7eph4n/PurgePage/releases/latest)
and extract it into the `extensions` directory of your MediaWiki installation.)

Then add the following line to your `LocalSettings.php`:
```php
wfLoadExtension('PurgePage');
```

## License

[GNU General Public License 2.0][license] or later.

[license]: https://www.gnu.org/copyleft/gpl.html
[mw-purge-page]: https://www.mediawiki.org/wiki/Extension:PurgePage
[composer]: https://getcomposer.org/
[SMW]: https://www.semantic-mediawiki.org
