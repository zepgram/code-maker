<?php
$output = $name_camel_case_resolver.'Output';
?>
<?php if ($type === 'query'): ?>
type Query {
<?php endif; ?>
<?php if ($type === 'mutation'): ?>
type Mutation {
<?php endif; ?>
    <?= $name_camel_case_resolver ?>(id: Int): <?= $output ?> @resolver(class: "<?= $use_escaped_resolver ?>") @doc(description:"<?= $description ?>")
}

type <?= $output ?> {

}
