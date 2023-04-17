<?php

declare(strict_types=1);

namespace Pest\Drift\Console;

use Pest\Drift\Converters\CodeConverterFactory;
use Pest\Drift\Converters\DirectoryConverter;
use Pest\Drift\Converters\FileConverter;
use Pest\Drift\Finder\Finder;
use Pest\Drift\Support\View;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @internal
 */
final class ConvertCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName('convert');

        $this->addArgument('dir', InputArgument::OPTIONAL, 'Test directory', 'tests');

        $this->addOption('exclude', 'e', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY);
        $this->addOption('output', 'd', InputOption::VALUE_REQUIRED);
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $testsDirectory = $input->getArgument('dir');
        assert(is_string($testsDirectory));

        $finder = new Finder($testsDirectory, $input->getOption('exclude'));

        $outputDir = $input->getOption('output') ?? $input->getArgument('dir');

        $codeConverterFactory = (new CodeConverterFactory());

        $directoryConverter = new DirectoryConverter(new FileConverter($codeConverterFactory->codeConverter(), $outputDir));


        $symfonyStyle->newLine();
        $symfonyStyle->write('  ');

        $changedTotal = $directoryConverter->convert($finder, function (bool $changed) use ($symfonyStyle): void {
            $symfonyStyle->write($changed ? '<fg=green;options=bold>✔</>' : '<fg=gray>.</>');
        });

        $symfonyStyle->newLine();

        View::renderUsing($symfonyStyle);
        View::render('components.badge', [
            'type' => 'INFO',
            'content' => 'The [' . $testsDirectory . '] directory has been migrated to PEST with ' . $changedTotal . ' files changed.',
        ]);

        return Command::SUCCESS;
    }
}
