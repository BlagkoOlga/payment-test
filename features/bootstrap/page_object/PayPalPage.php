<?php
/**
 * Created by IntelliJ IDEA.
 * User: olga
 * Date: 23/10/16
 * Time: 20:47
 */

namespace Page;


use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class PayPalPage extends Page
{
    protected $elements = array(
        'iframe' => array('css' => '#injectedUnifiedLogin>iframe'),
        'email'=>'#email',
        'password'=>'#password',
        'loginButton'=>'#btnLogin',
        'proceedButton'=>'#proceedButton',
        'amount'=>'.ltrOverride.ng-binding'

    );

    public function clickOnButtonCheckout($email, $password){
        $this->getSession()->switchToIFrame("injectedUl");

        $this->getElement('email')->click();
        $this->fillField("login_email", $email);

        $this->getElement('password')->click();
        $this->fillField("login_password", $password);

        $this->getElement('loginButton')->click();

        $this->getSession()->switchToWindow(null);
    }

    public function getAmount(){
        return $this->getElement('amount')->getText();
    }
}