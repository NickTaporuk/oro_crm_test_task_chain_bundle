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

create and add service in the chain
```yaml
# path_to_bundle/Resources/config/services.yml
parameters:
    chain.slave.name: PathToCommand

services:
    chain_command.transport.name:
        class: %chain.slave.name%
        tags:
            -  { name: chain_command.transport }
```

Usage
-----

The bundle registers one services:

 - the `chain_command.transport_chain` service execute chain;

 in Console command method execute

        public function execute(InputInterface $input, OutputInterface $output)
        {
            $container = $this->getApplication()->getKernel()->getContainer();
            $chain = $container->get('chain_command.transport_chain');

            $output->writeln(static::MESSAGE_MASTER);

            $chain->setMasterProcess($this->getName());
            $chain->setMasterMessageToLog(static::MESSAGE_MASTER);
            $chain->upChain();
        }

Development time
----------------
25 hours