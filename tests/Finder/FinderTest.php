<?php

use PestConverter\Finder\Finder;

it('find test file in one directory', function () {
    $finder = (new Finder(__DIR__ . '/../fixtures/Finder/Count'));

    expect($finder->count())->toEqual(2);
});

it('find test file in multiple directories', function () {
    $finder = (new Finder([
        __DIR__ . '/../fixtures/Finder/Count',
        __DIR__ . '/../fixtures/Finder/Count2',
    ]));

    expect($finder->count())->toEqual(4);
});

it('does not return excluded file', function () {
    $finder = (new Finder(__DIR__ . '/../fixtures/Finder/Count', 'TwoTest.php'));

    expect($finder->count())->toEqual(1);
});

it('does not return files in excluded directories', function () {
    $finder = (new Finder(__DIR__ . '/../fixtures/Finder/Count2', 'Recursive'));

    expect($finder->count())->toEqual(1);
});

it('does not return multiple excluded path', function () {
    $finder = (new Finder(
        [
            __DIR__ . '/../fixtures/Finder/Count',
            __DIR__ . '/../fixtures/Finder/Count2',
        ],
        [
            'TwoTest.php',
            'Recursive',
        ]
    ));

    expect($finder->count())->toEqual(2);
});

it('does not return non test files', function () {
    $files = (new Finder(__DIR__ . '/../fixtures/Finder'))->get();

    $files = array_map(function ($file) {
        return $file->getBasename();
    }, $files);

    expect($files)->not->toContain('OtherClass.php');
});
