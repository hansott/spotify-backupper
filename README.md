# Spotify Backupper

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


Create backups of your 

## Install

Via Composer

``` bash
$ composer require hansott/spotify-backupper
```

## Usage

```
$ spotify-backupper --help

--format <argument>
     The format for encoding your Spotify library. (json or xml)


--help
     Show the help page for this command.


--storage <argument>
     The backup storage. (local or dropbox)


--with-collaborative/--with-collab
     Whether to include collaborative playlists.
```

### Create a local backup

```
$ cd my-backup-dir
$ SPOTIFY_ACCESS_TOKEN=yourToken path/to/spotify-backupper
```

### Create a backup on Dropbox

```
$ SPOTIFY_ACCESS_TOKEN=yourToken DROPBOX_ACCESS_TOKEN=yourToken path/to/spotify-backupper --storage dropbox
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hansott@hotmail.be instead of using the issue tracker.

## Credits

- [Hans Ott][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/hansott/spotify-backupper.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/hansott/spotify-backupper/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/hansott/spotify-backupper.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/hansott/spotify-backupper.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/hansott/spotify-backupper.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/hansott/spotify-backupper
[link-travis]: https://travis-ci.org/hansott/spotify-backupper
[link-scrutinizer]: https://scrutinizer-ci.com/g/hansott/spotify-backupper/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/hansott/spotify-backupper
[link-downloads]: https://packagist.org/packages/hansott/spotify-backupper
[link-author]: https://github.com/hansott
[link-contributors]: ../../contributors
