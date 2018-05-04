<p align="center"><a href="http://www.hostnet.nl" target="_blank">
    <img width="400" src="https://www.hostnet.nl/images/hostnet.svg">
</a></p>

This component provides bank holidays and business day dates.
The component is created to make it easy to calculate holidays
in an extendable way.

Currently, this component only contains the Dutch holidays, but
pull requests for other (country's) bank holidays are welcome.

Installation
------------
Installation of the bundle can be done via [composer](https://getcomposer.org/) and is the recommended way of adding the bundle to your application. To do so, execute the following command to download the latest stable version of this bundle:
```bash
composer require hostnet/phpcs-tool
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

This bundle and the component follow [semantic versioning](http://semver.org/) strictly.

Usage
-----
```php
<?php
require_once('vendor/autoload.php');

$bank_holiday_resolver = new \Hostnet\Component\BankHoliday\BankHolidayResolver(\Hostnet\Component\BankHoliday\BankHoliday::DUTCH_BANK_HOLIDAY_SET);
$business_day_resolver = new \Hostnet\Component\BankHoliday\BusinessDayResolver($bank_holiday_resolver);

$business_day_resolver->isBusinessDay(new \DateTime('2017-04-17')); // false

foreach ($bank_holiday_resolver->getByDate(new \DateTime('2017-04-17')) as $bank_holiday) {
    print $bank_holiday . "\n"; // easter_monday
}
```

Requirements
------------

PHP 7.0.x or above.

License
-------

This library is licensed under the MIT License, meaning you can reuse the code
within proprietary software provided that all copies of the licensed software
include a copy of the MIT License terms and the copyright notice.

For more information, see the [LICENSE](LICENSE) file.
