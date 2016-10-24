<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Page\PayPalPage;
use Page\ProductPage;
use Page\ProceedPage;
use Page\ShippingPage;
use Page\PaymentPage;

require_once (__DIR__.'/page_object/ProductPage.php');
require_once(__DIR__.'/page_object/ProceedPage.php');
require_once(__DIR__.'/page_object/ShippingPage.php');
require_once (__DIR__.'/page_object/PaymentPage.php');
require_once (__DIR__.'/page_object/PaypalPage.php');

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext
{
    private $productPage;
    private $proceedPage;
    private $shippingPage;
    private $amountValue;
    private $paymentPage;
    private $payPalPage;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param ProductPage $productPage
     * @param ProceedPage $proceedPage
     * @param ShippingPage $shippingPage
     * @param PaymentPage $paymentPage
     */
    public function __construct(ProductPage $productPage, ProceedPage $proceedPage,
                                ShippingPage $shippingPage, PaymentPage $paymentPage, PayPalPage $payPalPage)
    {
        $this->productPage=$productPage;
        $this->proceedPage=$proceedPage;
        $this->shippingPage=$shippingPage;
        $this->paymentPage=$paymentPage;
        $this->payPalPage=$payPalPage;
    }

    /**
     * @BeforeScenario
     */
    public function resizeWindow()
    {
        $this->getSession()->resizeWindow(1440, 900, 'current');
    }

    /**
     * @AfterScenario
     */
    public function cleanCache()
    {
        $this->getSession()->reset();
    }


    /**
     * @Then /^I wait for the page to be loaded$/
     */
    public function iWaitForTheSuggestionBoxToAppear()
    {
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
    }

    /**
     * @Then /^I click on "Buy this item" button$/
     */
    public function iClickOnAddToCard(){
        $this->productPage->clickOnButtonAddToCard();
    }

    /**
     * @Then /^I click on "Proceed Checkout" button$/
     */
    public function iClickOnCheckoutButton(){
        $this->proceedPage->clickOnButtonCheckout();
    }

    /**
     * @Then /^I fill user personal data: "(?P<salutation>[^"]*)", "(?P<firstname>[^"]*)", "(?P<lastname>[^"]*)"$/
     */
    public function iFillUserPersonalDetail($salutation, $firstname, $lastname){
        $this->shippingPage->fillPersonalDetail($salutation, $firstname, $lastname);
    }

    /**
     * @Then /^I fill user address data: "(?P<street>[^"]*)", "(?P<number>[^"]*)", "(?P<country>[^"]*)", "(?P<city>[^"]*)", "(?P<zipcode>[^"]*)"$/
     */
    public function iFillUserAddressDetail($street, $number, $country, $city, $zipcode){
        $this->shippingPage->fillAddressDetail($street, $number, $country, $city, $zipcode);
        $this->shippingPage->clickOnNexButton();
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
    }

    /**
     * @When /^I click on button "Next"$/
     */
    public function iClickOnButtonNext(){
        $this->shippingPage->clickOnNexButton();
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
    }

    /**
     * @Then /^I charge payment with "(?P<email>[^"]*)"$/
     */
    public function iChargePayment($email){
        $this->getSession()->wait(5000, '(0 === jQuery.active)');
        $this->amountValue = $this->paymentPage->getAmountValue();
        $this->paymentPage->goToPayPal($email);
        $this->paymentPage->clickOnCharged();
    }

    /**
     * @Then /^I login on PayPal with: "(?P<email>[^"]*)" and "(?P<password>[^"]*)"$/
     */
    public function iLoginOnPayPal($email, $password){
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
        $this->payPalPage->clickOnButtonCheckout($email, $password);
    }

    /**
     * @Then /^I check amount value$/
     */
    public function iCheckAmountValue(){
        assert($this->amountValue, $this->payPalPage->getAmount());
    }

    /**
     * @Then /^I select "(?P<currency>[^"]*)"$/
     */
    public function iSelectCurrency($currency){
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
        $this->productPage->selectCurrency($currency);
    }

    /**
     * @Then /^I see current "(?P<currency>[^"]*)"$/
     */
    public function iSeeCurrentCurrency($currency){
        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
        assert($this->productPage->currentCurrency(), $currency);
    }

    /**
     * @When /^I delete items$/
     */
    public function iDeleteItems(){
        $this->proceedPage->deleteItems();
    }

    /**
     * @When /^I click on product link$/
     */
    public function iClickOnProductLink(){
        $this->proceedPage->returnToProductPage();
    }

    /**
     * @When /^I login with payever: "(?P<email>[^"]*)", "(?P<password>[^"]*)"$/
     */
    public function iLoginWithPayEver($email, $password){
        $this->shippingPage->loginWithPayever($email, $password);
    }

    /**
     * @When /^I click on charged button$/
     */
    public function iClickOnChargedButton(){
        $this->getSession()->wait(5000, '(0 === jQuery.active)');
        $this->paymentPage->clickOnCharged();
    }

    /**
     * @When /^I click on button back$/
     */
    public function iClickOnButtonBack(){
        $this->paymentPage->clickOnButtonBack();
        $this->getSession()->wait(5000, '(0 === jQuery.active)');
    }

    /**
     * @When /^I click on product block$/
     */
    public function iClickOnProductBlock(){
        $this->getSession()->wait(5000, '(0 === jQuery.active)');
        $this->amountValue = $this->paymentPage->getAmountValue();
        $this->paymentPage->clickOnProductDetail();
    }

    /**
     * @Then /^I compare total amount$/
     */
    public function iCompareAmount(){
        assert($this->amountValue, $this->paymentPage->getTotalValue());
    }

    /**
     * @Then /^I proceed payment$/
     */
    public function iProceedPayment(){
        $this->payPalPage->agreeWithPayment();
    }

}
