<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_plugin ?>;

use <?= "$target_class" ?>;

class <?= "$name_plugin\n" ?>
{
<?php if ($plugin_method === 'before'): ?>
    /**
     * @param <?= $target_class_name ?> $subject
     */
    public function before<?= $target_method ?>(<?= $target_class_name ?> $subject)
    {
        // @todo: implement plugin before
    }
<?php elseif ($plugin_method === 'around'): ?>
    /**
     * @param <?= $target_class_name ?> $subject
     * @param callable $proceed
     */
    public function around<?= $target_method ?>(<?= $target_class_name ?> $subject, callable $proceed)
    {
        // @todo: implement plugin around
    }
<?php elseif ($plugin_method === 'after'): ?>
    /**
     * @param <?= $target_class_name ?> $subject
     * @param $result
     */
    public function after<?= $target_method ?>(<?= $target_class_name ?> $subject, $result)
    {
        // @todo: implement plugin after
    }
<?php endif; ?>
}
