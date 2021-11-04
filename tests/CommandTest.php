<?php

use PestConverter\Console\ConvertCommand;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Tester\CommandTester;

it('execute successfully', function () {
    $convertCommand = new ConvertCommand();
    $commandTester = new CommandTester($convertCommand);

    $tmpDir = tmpDir();

    $code = $commandTester->execute([
        'dir' => tmpDir('sources'),
        '--output' => tmpDir('results'),
    ]);

    expect($convertCommand->getName())->toBe('convert');
    expect($code)->toBe(BaseCommand::SUCCESS);
    expect(tmpDir('results'))->toBeDirectory();
    expect(scandir(tmpDir('results')))->toEqualCanonicalizing([
        '.',
        '..',
        'FooTest.php',
        'BarTest.php',
        'Alpha',
        'Beta',
    ]);
});
