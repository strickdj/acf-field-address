<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('login as admin.');
$I->login('tester', 'test');
$I->see('Howdy, tester');
