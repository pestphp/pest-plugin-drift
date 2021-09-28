<?php

use PestConverter\Console\ConvertCommand;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Tester\CommandTester;

it('execute successfully', function () {
    $convertCommand = new ConvertCommand();
    $commandTester = new CommandTester($convertCommand);

    $tmpDir = tmpDir();

    $code = $commandTester->execute([
        'dir' => __DIR__ . '/fixtures/Converters/',
        '--output' => $tmpDir,
    ]);

    expect($convertCommand->getName())->toBe('convert');
    expect($code)->toBe(BaseCommand::SUCCESS);
    expect($tmpDir)->toBeDirectory();
    expect(scandir($tmpDir))->toEqualCanonicalizing([
        '.',
        '..',
        'FooTest.php',
        'BarTest.php',
        'Recursive',
    ]);
});
