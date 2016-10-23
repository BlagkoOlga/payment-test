<?php
/**
 * Created by IntelliJ IDEA.
 * User: olga
 * Date: 23/10/16
 * Time: 20:45
 */

namespace Page;


use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class PaymentPage extends Page
{

    protected $elements = array(
        'emailField' => array('css' => '#payment_dto_payment_customerEmail'),
        'paymentTerms'=>'#payment_dto_acceptTermsPayever',
        'chargeButton'=>'.footer-submit-btn.footer-btn.btn.btn-blue',
        'amountValue'=>array('css' => '#amount_value_title'),
        'button back'=>array('css'=>'.payment-back-btn'),
        'Total value'=>array('css'=>'#shop_payment_total_value'),
        'Product detail'=>array('css'=>'#amount_value_block')
    );

    public function goToPayPal($email){
        $this->getElement('emailField')->click();
        $this->fillField("Email", $email);
        $this->getElement('paymentTerms')->check();

    }

    public function getAmountValue(){
      return $this->getElement('amountValue')->getText();
    }

    public function clickOnCharged(){
        $this->getElement('chargeButton')->click();
    }

    public function  clickOnButtonBack(){
        $this->getElement('button back')->click();
    }

    public function clickOnProductDetail(){
        $this->getElement('Product detail')->click();
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
    }

    public function getTotalValue(){
        return $this->getElement('Total value')->getText();
    }

}