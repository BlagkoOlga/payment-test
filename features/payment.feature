Feature: Payment Form
  Customer select product and see payment page

  Scenario: Open payment page
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I wait for the page to be loaded
    Then I should see text matching "Proceed to checkout"

  Scenario: Check current currency
    Given I am on "/2791"
    Then the "#header-product .current-currency" element should contain "EUR"

  Scenario: Check Imprint Text
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I press "btn-impressum"
    Then the "#shop-info-modal h3" element should contain "Marketing"

  Scenario Outline: Change currency
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I select "<currency>"
    Then I see current "<currency>"
    And I wait for the page to be loaded
    And the ".price-holder" element should contain "<sign>"
    Examples:
      | currency |sign|
      |EUR       | €  |
      |USD       | $  |
      |GBP       | £  |
      |CHF       |CHF |
      |DKK       |DKK |
      |NOK       |NOK |

  Scenario: Checkout button hide after delete product item
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I delete items
    Then I should not see text matching "Proceed to checkout"

  Scenario: Return to detail product page
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on product link
    Then I should see text matching "Buy this item"

  Scenario: Checkout with empty shipping fields
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on "Proceed Checkout" button
    And I click on button "Next"
    And I wait for the page to be loaded
    Then I should see text matching "Please select your salutation."
    Then I should see text matching "Please enter your first name."
    Then I should see text matching "Please enter your last name."
    Then I should see text matching "Please enter your street."
    Then I should see text matching "Please enter your street number."
    Then I should see text matching "Please select your home country."
    Then I should see text matching "Please enter your city."
    Then I should see text matching "Please enter a valid zip code."

  Scenario Outline: Invalid ogin with payever
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on "Proceed Checkout" button
    And I login with payever: "<email>", "<password>"
    Then I should see text matching "Bad credentials."
    Examples:
      |email                |password  |
      |baloonisred@gmail.com|1q2w3e4r5t|

  Scenario Outline: Charge with errors
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on "Proceed Checkout" button
    And I fill user personal data: "<salutation>", "<firstname>", "<lastname>"
    And I fill user address data: "<street>", "<number>", "<country>", "<city>", "<zipcode>"
    And I click on charged button
    Then I should see text matching "A few fields are incorrect or missing. Please find them below."
    Then I should see text matching "You must accept our terms of service."
    Examples:
      |salutation   |firstname|lastname|street     |number|country  |city         |zipcode|
      |SALUTATION_MR|Julia    |Max     |Broadway Av|200   |Australia|WEST BEACH SA|5024   |

  Scenario Outline: Return to Shipping Page
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on "Proceed Checkout" button
    And I fill user personal data: "<salutation>", "<firstname>", "<lastname>"
    And I fill user address data: "<street>", "<number>", "<country>", "<city>", "<zipcode>"
    And I click on button back
    Then I should see text matching "Shipping"
    Examples:
      |salutation   |firstname|lastname|street     |number|country  |city         |zipcode|
      |SALUTATION_MR|Julia    |Max     |Broadway Av|200   |Australia|WEST BEACH SA|5024   |

  Scenario Outline: Open detail information about product
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on "Proceed Checkout" button
    And I fill user personal data: "<salutation>", "<firstname>", "<lastname>"
    And I fill user address data: "<street>", "<number>", "<country>", "<city>", "<zipcode>"
    And I click on product block
    Then I compare total amount
    Examples:
      |salutation   |firstname|lastname|street     |number|country  |city         |zipcode|
      |SALUTATION_MR|Julia    |Max     |Broadway Av|200   |Australia|WEST BEACH SA|5024   |

  Scenario Outline: Proceed
    Given I am on "/2791"
    And I wait for the page to be loaded
    When I click on "Buy this item" button
    And I click on "Proceed Checkout" button
    And I fill user personal data: "<salutation>", "<firstname>", "<lastname>"
    And I fill user address data: "<street>", "<number>", "<country>", "<city>", "<zipcode>"
    And I charge payment with "<email>"
    And I login on PayPal with: "<email>" and "<password>"
    And I wait for the page to be loaded
    And I proceed payment
    Then I should see text matching "Payment successfull"
    Examples:
      |salutation   |firstname|lastname|street     |number|country  |city         |zipcode|email                |password  |
      |SALUTATION_MR|Julia    |Max     |Broadway Av|200   |Australia|WEST BEACH SA|5024   |blagko.olga-buyer@gmail.com|1q2w3e4r5t|






