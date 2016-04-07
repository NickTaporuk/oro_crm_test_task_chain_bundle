<?php

namespace ChainCommandBundle\Chain;

final class ChainConsoleLogMessage {

    const MESSAGE_MASTER                    = 'CHAIN MASTER';
    const MESSAGE_LOG_MASTER                = '%s is a master command of a command chain that has registered member commands';
    const MESSAGE_LOG_SLAVE                 = '%s registered as a member of %s command chain';
    const MESSAGE_LOG_EXECUTING_MASTER      = 'Executing %s command itself first';
    const MESSAGE_LOG_EXECUTING_ALL_COMMAND = 'Execution of %s chain completed.';
    const MESSAGE_ERROR_SLAVE               = 'Error: %s command is a member of %s command chain and cannot be executed on its own.';

}