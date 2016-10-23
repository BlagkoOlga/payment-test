<?php
/**
 * Created by IntelliJ IDEA.
 * User: olga
 * Date: 23/10/16
 * Time: 14:44
 */

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class ShippingPage extends Page
{
    protected $elements = array(
        'shippingForm' => 'form.shipping-address-form',
        'nextButton' =>'.icon-btn.icon-btn-filled',
        'firstName'=>'#shipping_step_newShippingAddress_firstName',
        'lastName' =>'#shipping_step_newShippingAddress_lastName',
        'salutation'=>'#shipping_step_newShippingAddress_salutation',
        'country'=>'#shipping_step_newShippingAddress_country',
        'street'=>'#shipping_step_newShippingAddress_street',
        'number'=>'#shipping_step_newShippingAddress_streetNumber',
        'city'=>'#shipping_step_newShippingAddress_city',
        'zipcode'=>'#shipping_step_newShippingAddress_zipCode',
        'Address new'=>'#shipping_step_newShippingAddress_addressAutocomplete',
        'map icon'=>'.form-design.form-widget.has-icon .icon.icon-24',
        'Login with payever'=>'.link.shipping-login-link',
        'User name'=>'#username',
        'Password'=>'#password',
        'Login Button'=>'.btn-link'
    );


    public function fillPersonalDetail($salutation, $firstname, $lastname)
    {
        $this->getElement('salutation')->selectOption($salutation);
        $this->getElement('firstName')->click();
        $this->fillField("First name", $firstname);
        $this->getElement('lastName')->click();
        $this->fillField("Last name", $lastname);
    }

    public function fillAddressDetail($street, $number, $country, $city, $zipcode)
    {
        $this->getElement('Address new')->click();
        $this->fillField("Street Address", $country);

        $this->getElement('map icon')->click();

        $this->getElement('street')->click();
        $this->fillField("Street", $street);

        $this->getElement('number')->click();
        $this->fillField("Number", $number);

        $this->getElement('country')->selectOption($country);

        $this->getElement('city')->click();
        $this->fillField("City", $city);

        $this->getElement('zipcode')->click();
        $this->fillField("Zip", $zipcode);
    }

    public function clickOnNexButton(){
        $this->getElement('nextButton')->click();
    }

    public function loginWithPayever($email, $password){
        $this->getElement('Login with payever')->click();

        $this->getSession()->wait(5000, 'window.jQuery !== undefined');

        $this->getElement('User name')->click();
        $this->fillField("_username", $email);

        $this->getElement('Password')->click();
        $this->fillField("_password", $password);

        $this->getElement('Login Button')->click();

        $this->getSession()->wait(5000, 'window.jQuery !== undefined');
    }

}