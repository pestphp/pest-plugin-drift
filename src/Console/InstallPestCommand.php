<?php

declare(strict_types=1);

namespace Pest\Pestify\Console;

use Composer\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
final class InstallPestCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName('init');
        $this->addOption('laravel', null, InputOption::VALUE_NONE);
    }

    /**
     * {@inheritDoc}
     */
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

        if ($input->getOption('laravel')) {
            // Install Pest Laravel Plugin
            $application->run(new ArrayInput([
                'command' => 'require',
                '--dev' => null,
                'packages' => [
                    'pestphp/pest-plugin-laravel ',
                ],
            ]), $output);

            $output->writeln('> Run the command "php artisan pest:install" to finish the installation.');
        } else {
            // Initialize Pest
            $application->run(new ArrayInput([
                'command' => 'exec',
                'binary' => 'pest --init',
            ]), $output);
        }

        return Command::SUCCESS;
    }
}
