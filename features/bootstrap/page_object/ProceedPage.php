<?php
namespace Page;
/**
 * Created by IntelliJ IDEA.
 * User: olga
 * Date: 23/10/16
 * Time: 14:20
 */

namespace Page;


use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class ProceedPage extends Page
{
    protected $elements = array(
        'Checkout button' => array('xpath' => '//a[contains(@class,\'submits-checkout\')]'),
        'Delete item'=>array ('css'=>'.times'),
        'Product link'=>array('css'=>'a.name')

    );

    public function clickOnButtonCheckout(){
        $this->getSession()->wait(10000, "document.readyState === 'complete'");
        $this->getElement('Checkout button')->click();
    }

    public function deleteItems(){
        $this->getElement('Delete item')->click();
    }

    public function returnToProductPage(){
        $this->getElement('Product link')->click();
    }
}