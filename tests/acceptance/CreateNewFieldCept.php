<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('add a new address field.');
$I->login('tester', 'test');
$I->amOnPage('/wp/wp-admin/post.php?post=4&action=edit');
$I->see('+ Add Field');
$I->click('+ Add Field');
$I->fillField('.field-label', 'acf address test field');
$I->selectOption('form select.field-type', 'address');
$I->wait(2);
$I->seeElement('.acf-address-1-row');
$I->click('#publish');
$I->see('Field group updated.');
