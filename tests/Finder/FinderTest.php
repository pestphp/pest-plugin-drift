<?php

use Pest\Pestify\Finder\Finder;

it('find test file in one directory', function () {
    $finder = new Finder(tmpDir('sources/Alpha'));

    expect($finder->count())->toEqual(2);
});

it('find test file in multiple directories', function () {
    $finder = (new Finder([
        tmpDir('sources/Alpha'),
        tmpDir('sources/Beta'),
    ]));

    expect($finder->count())->toEqual(4);
});

it('does not return excluded file', function () {
    $finder = (new Finder(tmpDir('sources/Alpha'), 'WorldTest.php'));

    expect($finder->count())->toEqual(1);
});

it('does not return files in excluded directories', function () {
    $finder = (new Finder(tmpDir('sources/Beta'), 'Charlie'));

    expect($finder->count())->toEqual(1);
});

it('does not return multiple excluded path', function () {
    $finder = (new Finder(
        [
            tmpDir('sources/Alpha'),
            tmpDir('sources/Beta'),
        ],
        [
            'HelloTest.php',
            'Charlie',
        ]
    ));

    expect($finder->count())->toEqual(2);
});

it('does not return non test files', function () {
    $files = (new Finder(tmpDir('sources')))->get();

    $files = array_map(function ($file) {
        return $file->getBasename();
    }, $files);

    expect($files)->not->toContain('OtherClass.php');
});
