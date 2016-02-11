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

$I->wantTo('make changes to the default address settings.');
// has the form ${obj.id}-${widgetCount}
$I->uncheckOption('#street2-1');
$I->wait(1);
// has the form ${obj.id}-li-movable-${widgetCount}
$I->dontSeeElement('#street2-li-movable-1');

$I->click('#publish');
$I->see('Field group updated.');
$I->wantTo('make sure my changes were persisted.');
$I->dontSeeCheckboxIsChecked('#street2-1');
$I->dontSeeElement('#street2-li-movable-1');
