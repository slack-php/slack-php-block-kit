<?php
if (!isset($classNamespace, $classFullname, $className)) {
    echo "Undeclared template variables.\n";
    exit(1);
}
?>

declare(strict_types=1);

<?php if ($classNamespace): ?>
namespace Jeremeamia\Slack\BlockKit\Tests\<?= $classNamespace ?>;
<?php else: ?>
namespace Jeremeamia\Slack\BlockKit\Tests;
<?php endif ?>

use Jeremeamia\Slack\BlockKit\<?= $classFullname ?>;
<?php if ($classNamespace): ?>
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
<?php endif ?>

/**
 * @covers \Jeremeamia\Slack\BlockKit\<?= $classFullname ?>

 */
class <?= $className ?>Test extends TestCase
{
    public function testThatSomethingDoesSomething()
    {
        $this->assertTrue(class_exists(<?= $className ?>::class));
    }
}
