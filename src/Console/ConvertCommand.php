<?php

declare(strict_types=1);

namespace Pest\Pestify\Console;

use Pest\Pestify\Converters\CodeConverterFactory;
use Pest\Pestify\Converters\DirectoryConverter;
use Pest\Pestify\Converters\FileConverter;
use Pest\Pestify\Finder\Finder;
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
    protected function configure(): void
    {
        $this->setName('convert');
        $this->addArgument('dir', InputArgument::REQUIRED, 'Test directory');
        $this->addOption('exclude', 'e', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY);
        $this->addOption('output', 'd', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $testsDirectory = $input->getArgument('dir');

        $symfonyStyle->info("Start converting files from: $testsDirectory");

        $finder = new Finder($testsDirectory, $input->getOption('exclude'));

        $outputDir = $input->getOption('output') ?? $input->getArgument('dir');

        $codeConverterFactory = (new CodeConverterFactory());

        $directoryConverter = new DirectoryConverter(new FileConverter($codeConverterFactory->codeConverter(), $outputDir));

        $directoryConverter->convert($finder);

        $symfonyStyle->info("Done! {$finder->count()} files have been processed.");

        return Command::SUCCESS;
    }
}
