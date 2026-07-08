# composer-binary-checker
Plugin for Composer to require the presence of a binary on the target system

## Configuring required system binaries

On every `composer install` and `composer update`, a check runs to verify
that certain system binaries are available in the `PATH`. The list of these
binaries is maintained in `composer.json` under `extra.required-binaries`:

```json
{
    "extra": {
        "required-binaries": ["graphicsmagick", "qpdf"]
    }
}
```

To add another binary, simply add its name (as it is invoked on the command
line) to this array. If one of the listed binaries is missing on the system,
Composer aborts with an error message. These binaries are not installed by
Composer and must be provided on the system manually (e.g. via the
operating system's package manager).
