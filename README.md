ChainCommandBundle
==================

Installation
------------


If you need to change the binaries, change the instance options or even disable one or both services, you can do it through the configuration.

```yaml
# app/config/config.yml
chain_command:
    master: 'command:name'
```

Where command:name is master command name

```yaml
# app/config/config.yml
monolog:
    handlers:
        ...
        chain:
            type: stream
            path: "%kernel.logs_dir%/chain.log"
            level: debug
            formatter: chain_log_formatter
            channels: chain
```

Usage
-----

The bundle registers two services:

 - the `knp_snappy.image` service allows you to generate images;
 - the `knp_snappy.pdf` service allows you to generate pdf files.
