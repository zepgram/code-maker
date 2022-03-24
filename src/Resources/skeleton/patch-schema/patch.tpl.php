<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_patch ?>;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;

class <?= $name_patch ?> implements SchemaPatchInterface
{
    /** @var SchemaSetupInterface */
    private $schemaSetup;

    /**
     * @param SchemaSetupInterface $schemaSetup
     */
    public function __construct(
        SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        $this->schemaSetup->getConnection()->startSetup();

        $this->schemaSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
