<?php

declare(strict_types=1);

// Make sure a relative FQCN is provided.
$classFullname = $argv[1] ?? null;
if (!$classFullname) {
    echo "The class name to be tested was not provided\n";
    echo "Please provide a class name (including namespace) relative to SlackPhp\\BlockKit.\n";
    exit(1);
}

// Setup variables needed for template.
$parts = explode('\\', $classFullname);
$className = array_slice($parts, -1)[0];
$classNamespace = implode('\\', array_slice($parts, 0, -1));

// Fill the template to create the content.
ob_start();
require __DIR__ . '/test-template.php';
$fileContent = "<?php\n" . ob_get_clean();

// Determine the directory and create it if needed.
$fileDir = realpath(__DIR__ . '/../tests') . '/' . strtr($classNamespace, ['\\' => '/']);
if (!is_dir($fileDir)) {
    mkdir($fileDir, 0755, true);
}

// Create the new test file.
$filePath = "/{$className}Test.php";
echo "Creating test file for {$classFullname}\n";
file_put_contents("{$fileDir}{$filePath}", $fileContent);
