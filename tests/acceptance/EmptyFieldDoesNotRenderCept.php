<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('make sure empty address fields dont render any html.');
$I->amOnPage('/2016/02/11/test-field-with-empty-address/');
$I->dontSeeElement('div.sim_address_field');
