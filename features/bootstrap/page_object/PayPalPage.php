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
        'email'=>array('css' => '#email'),
        'password'=>array('css' => '#password'),
        'loginButton'=>array('css' => '#btnLogin'),
        'agreeCheckbox'=>array('css' => '#agree'),
        'agreeAndContinueButton'=>array('css'=>'#submitEConsent'),
        'amountValue'=>array('css'=>'#totalWrapper [ng-bind-html=\'amount_formatted\']'),
        'confirmPayment'=>array('css'=>'#confirmButtonTop')

    );

    public function clickOnButtonCheckout($email, $password){
        $this->getSession()->switchToIFrame("injectedUl");

        $this->getElement('email')->click();
        $this->fillField("login_email", $email);

        $this->getElement('password')->click();
        $this->fillField("login_password", $password);

        $this->getElement('loginButton')->click();

        $this->getSession()->switchToWindow(null);
        $this->getSession()->wait(10000, 'window.jQuery !== undefined');
    }

    public function getAmount(){
        return $this->getElement('amountValue')->getText();
    }

    public function agreeWithPayment(){
        $this->getElement('confirmPayment')->click();

        $this->getSession()->wait(10000, 'window.jQuery !== undefined');
    }
}