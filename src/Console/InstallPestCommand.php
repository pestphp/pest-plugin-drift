<?php

declare(strict_types=1);

namespace PestConverter\Console;

use Composer\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InstallPestCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('init');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('memory_limit', '512M');

        $application = new Application();
        $application->setAutoExit(false);

        // Install Pest
        $application->run(new ArrayInput([
            'command' => 'require',
            '--dev' => null,
            '--with-all-dependencies' => null,
            'packages' => [
                'pestphp/pest ',
            ],
        ]), $output);

        // Initialize Pest
        $application->run(new ArrayInput([
            'command' => 'exec',
            'binary' => 'pest --init',
        ]), $output);

        return Command::SUCCESS;
    }
}
