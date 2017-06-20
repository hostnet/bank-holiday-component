# bank-holiday-component
Component that provides bank holidays and business day dates.
The component is created to make it easy to calculate holidays
in an extendable way.

Currently, this component only contains the Dutch holidays, but
pull requests for other (country's) bank holidays are welcome.

Installation
------------
Install the latest version via [composer](https://getcomposer.org/):
```bash
php composer.phar require hostnet/bank-holiday-component
```

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
