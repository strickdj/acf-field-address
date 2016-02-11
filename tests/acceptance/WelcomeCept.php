<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/');
$I->see('Just another WordPress site');


$I->login('tester', 'test');

$I->see('Howdy, tester');
