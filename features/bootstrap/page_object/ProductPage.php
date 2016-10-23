<?php
namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
/**
 * Created by IntelliJ IDEA.
 * User: olga
 * Date: 23/10/16
 * Time: 08:59
 */
class ProductPage extends Page
{
    protected $elements = array(
        'Add to card' => array('xpath' => '//button[contains(@class,\'add-to-cart\')]'),
        'currencySelect'=>array('css'=>'#header-product #dropdownMenu1'),
        'currentCurrency'=>array('css'=>'#header-product .current-currency'),
        'currentSign'=>array('css'=>'".price-holder"'),
        'changeLanguage'=>array('css'=>'.btn.btn-default.dropdown-toggle.language-switcher-opener')

    );

    public function clickOnButtonAddToCard(){
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
        $this->getElement('Add to card')->click();
    }

    public function selectCurrency($currency){
        $this->getElement('currencySelect')->click();
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
        $element = $this->getSession()->getPage()->find("xpath",$this->getSession()->getSelectorsHandler()->selectorToXpath('xpath', '//*[@id=\'header-product\']//li/a[text()="'. $currency .'"]'));
        $element->click();
    }

    public function currentCurrency(){
        return $this->getElement('currentCurrency')->getText();
    }
}