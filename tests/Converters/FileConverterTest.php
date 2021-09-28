<?php

use PestConverter\Converters\CodeConverterFactory;
use PestConverter\Converters\FileConverter;
use PestConverter\Finder\File;
use Symfony\Component\Finder\SplFileInfo;

it('create converted file', function () {
    $splFileInfo = new SplFileInfo(
        __DIR__ . '/../fixtures/Converters/FooTest.php',
        '',
        '/'
    );

    $file = new File($splFileInfo);

    $codeConverter = (new CodeConverterFactory())->codeConverter();

    (new FileConverter($codeConverter, tmpDir()))->convert($file);

    expect(file_exists(tmpDir() . '/FooTest.php'))->toBeTrue();
});
