<?php

use Pest\Drift\Finder\Finder;

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

it('does not return non test files', function () {
    $files = (new Finder(tmpDir('sources')))->get();

    $files = array_map(function ($file) {
        return $file->getBasename();
    }, $files);

    expect($files)->not->toContain('OtherClass.php');
});
