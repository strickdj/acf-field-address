<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/');
$I->see('Just another WordPress site');


$I->login('tester', 'test');

$I->see('Howdy, tester');

$I->amOnPage('/wp/wp-admin/post.php?post=4&action=edit');

$I->see('+ Add Field');

$I->click('+ Add Field');

$I->fillField('.field-label', 'acf address test field');

$I->selectOption('form select.field-type', 'address');

$I->wait(3);

$I->seeElement('.acf-address-1-row');
