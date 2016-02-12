<?php
$address = "1021 IN-47
1021 IN-47
1021 IN-47
Crawfordsville, IN 47933 US";

$I = new AcceptanceTester($scenario);
$I->wantTo('see my address field rendered in html.');
$I->amOnPage('/2016/02/11/basic-html-output-test-field/');
$I->see($address);
