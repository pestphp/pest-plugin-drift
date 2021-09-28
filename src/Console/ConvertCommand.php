<?php

declare(strict_types=1);

namespace PestConverter\Console;

use PestConverter\Converters\CodeConverterFactory;
use PestConverter\Converters\DirectoryConverter;
use PestConverter\Converters\FileConverter;
use PestConverter\Finder\Finder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $finder = new Finder($input->getArgument('dir'), $input->getOption('exclude'));

        $outputDir = $input->getOption('output') ?? $input->getArgument('dir');

        $codeConverterFactory = (new CodeConverterFactory());

        $directoryConverter = new DirectoryConverter(new FileConverter($codeConverterFactory->codeConverter(), $outputDir));

        $directoryConverter->convert($finder);

        $symfonyStyle = new SymfonyStyle($input, $output);

        $symfonyStyle->success('Done!');

        return Command::SUCCESS;
    }
}
