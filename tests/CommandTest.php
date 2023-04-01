<?php

use Pest\Pestify\Console\ConvertCommand;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Tester\CommandTester;

it('execute successfully', function () {
    $convertCommand = new ConvertCommand();
    $commandTester = new CommandTester($convertCommand);

    $code = $commandTester->execute([
        'dir' => tmpDir('sources'),
        '--output' => tmpDir('results'),
    ]);

    expect($convertCommand->getName())->toBe('convert')
        ->and($code)->toBe(BaseCommand::SUCCESS)
        ->and(tmpDir('results'))->toBeDirectory()
        ->and(scandir(tmpDir('results')))->toEqualCanonicalizing([
            '.',
            '..',
            'FooTest.php',
            'BarTest.php',
            'Alpha',
            'Beta',
        ]);
});
