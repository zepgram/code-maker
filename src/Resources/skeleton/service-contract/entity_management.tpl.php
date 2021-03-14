<?php
$nameEntityFactory = $name_camel_case_entity. 'Factory';
$classEntityFactory = $name_entity_interface. 'Factory';
$useEntityFactory = $use_entity_interface. 'Factory';
?>
<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_entity_management ?>;

use <?= $use_entity_management_interface ?>;
use <?= $use_entity_repository_interface ?>;
use <?= $useEntityFactory ?>;

class <?= $name_entity_management ?> implements <?= "$name_entity_management_interface\r\n" ?>
{
    /**
     * @var <?= "$classEntityFactory\r\n" ?>
     */
    private $<?= $nameEntityFactory ?>;

    /**
     * @var <?= "$name_entity_repository_interface\r\n" ?>
     */
    private $<?= $name_camel_case_entity_repository ?>;

    /**
     * <?= $name_entity_management ?> constructor.
     *
     * @param <?= "$classEntityFactory $$nameEntityFactory\r\n" ?>
     * @param <?= "$name_entity_repository_interface $$name_camel_case_entity_repository\r\n" ?>
     */
    public function __construct(
        <?= "$classEntityFactory $$nameEntityFactory,\r\n" ?>
        <?= "$name_entity_repository_interface $$name_camel_case_entity_repository\r\n" ?>
    ) {
        $this-><?= $nameEntityFactory ?> = $<?= $nameEntityFactory ?>;<?= "\r\n" ?>
        $this-><?= $name_camel_case_entity_repository ?> = $<?= $name_camel_case_entity_repository ?>;<?= "\r\n" ?>
    }

    // @todo: create business code here
}
