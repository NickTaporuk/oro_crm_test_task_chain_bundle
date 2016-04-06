ChainCommandBundle
==================

Installation
------------


If you need to change the binaries, change the instance options or even disable one or both services, you can do it through the configuration.

```yaml
# app/config/config.yml
knp_snappy:
    pdf:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltopdf #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"" for Windows users
        options:    []
    image:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltoimage #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltoimage.exe\"" for Windows users
        options:    []
```

If you want to change temporary folder which is ```sys_get_temp_dir()``` by default, you can use

```yaml
# app/config/config.yml
knp_snappy:
    temporary_folder: %kernel.cache_dir%/snappy
```

Usage
-----

The bundle registers two services:

 - the `knp_snappy.image` service allows you to generate images;
 - the `knp_snappy.pdf` service allows you to generate pdf files.
