<?php
<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('add a new address field with custom options.');
$I->login('tester', 'test');
$I->amOnPage('/wp/wp-admin/post.php?post=4&action=edit');
$I->click('+ Add Field');
$I->fillField('.field-label', 'acf address custom test field');
$I->selectOption('form select.field-type', 'address');
$I->wait(2);
$I->seeElement('.acf-address-1-row');

$I->uncheckOption();

$I->click('#publish');
$I->see('Field group updated.');
