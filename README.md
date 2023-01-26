# FIAS GAR Data Import Tool

Tool to import FIAS GAR database.

Федеральная Информационная Адресная Система
Государственный Адресный Реестр - ФИАС ГАР

## How to install

`composer require sbwerewolf/fias-gar-data-import-tool`

## How to use

Import may run in two modes:

- deploy data to empty database (SQL insert)
- import updates to working database (SQL update)

The behaviour of import command depends on `ImportOptions` DTO (data
transfer object).

If `ImportOptions::$doAddNewWithCheck` is `false`, than import do not
checks record existence, and straight off perform SQL INSERT.

In case when `ImportOptions::$doAddNewWithCheck` is `true`, before do
INSERT/UPDATE, import checks record existence, and perform suitable
operation.

For perform import, you first step is define `ImportOptions`, and then
exec `\SbWereWolf\FiasGarDataImport\Cli\ImportCommand::run` with early
defined options.

### Preliminary Steps

- Deploy database with Composer package
  `sbwerewolf/fias-gar-schema-deploy-tool`
- Create index, in common case on (region,id) columns

### Script `data-import.php` Is Example Of Using of Import Command

- Create .env file with DB credentials, and other parameters
- Copy-paste [test/data-import.php](test/data-import.php)
- Correct all paths into [test/data-import.php](test/data-import.php)
- Check file mask lists, remove unnecessary
- Run script [test/data-import.php](test/data-import.php)

## Contacts

```
Volkhin Nikolay
e-mail ulfnew@gmail.com
phone +7-902-272-65-35
Telegram @sbwerewolf
```

Chat with me via messenger

- [Telegram chat with me](https://t.me/SbWereWolf)
- [WhatsApp chat with me](https://wa.me/79022726535) 