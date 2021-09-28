<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');
uses()
    ->beforeAll(function () {
        if (is_dir(tmpDir())) {
            cleanTmpDir();
        } else {
            mkdir(tmpDir());
        }
    })
    ->afterAll(fn () => cleanTmpDir())
    ->in('CommandTest.php', 'Converters/FileConverterTest.php');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function tmpDir()
{
    return realpath(sys_get_temp_dir()) . '/pest_converter';
}


function cleanTmpDir()
{
    $paths = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(tmpDir(), \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($paths as $path) {
        if ($path->isDir()) {
            if ($path->isLink()) {
                @unlink($path);
            } else {
                @rmdir($path);
            }
        } else {
            @unlink($path);
        }
    }
}
