<?php

test('files are not modified', function () {
    $output = shell_exec(__DIR__ . '/../../vendor/bin/pest --colors=never --drift tests/Fixtures/already-converted-project');

    expect($output)->toMatchSnapshot();
})->group('already-converted-project');
