<?php
if (!isset($classNamespace, $classFullname, $className)) {
    echo "Undeclared template variables.\n";
    exit(1);
}
?>

declare(strict_types=1);

<?php if ($classNamespace): ?>
namespace SlackPhp\BlockKit\Tests\<?= $classNamespace ?>;
<?php else: ?>
namespace SlackPhp\BlockKit\Tests;
<?php endif ?>

use SlackPhp\BlockKit\<?= $classFullname ?>;
<?php if ($classNamespace): ?>
use SlackPhp\BlockKit\Tests\TestCase;
<?php endif ?>

/**
 * @covers \SlackPhp\BlockKit\<?= $classFullname ?>

 */
class <?= $className ?>Test extends TestCase
{
    public function testThatSomethingDoesSomething()
    {
        $this->assertTrue(class_exists(<?= $className ?>::class));
    }
}
