
# Before running tests
1. install php
2. install composer:
   "curl -sS https://getcomposer.org/installer | php"
3. create composer.json file with needed configuration
4. php composer.phar install - install needed instruments
5. php vendor/bin/behat --init

# Running test
1. in one terminal window strart selenium server
  "java -jar selenium-server-standalone-2.53.1.jar -Dwebdriver.chrome.driver="chromedriver""
2. Run scenarios:
   "php vendor/bin/behat" - for all features
   "php vendor/bin/behat features/payment.feature" - for needed feature
