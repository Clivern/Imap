Imap
====
:mailbox_with_mail: Access Mailbox Using PHP IMAP.

*Current Version: coming soon*

[![Build Status](https://travis-ci.org/Clivern/Imap.svg?branch=master)](https://travis-ci.org/Clivern/Imap)

Installation
------------

To install the package via `composer`, use the following:

```php
composer require clivern/imap
```
This command requires you to have Composer installed globally.


Usage
-----

After adding the package as a dependency, Please read the following steps:

### Connect and Authenticate

```php
include_once dirname(__FILE__) . '/vendor/autoload.php';

$connection = new Clivern\Imap\Core\Connection(
	"imap.gmail.com",
	"993",
	"test@clivern.com",
	"my_password",
	"/ssl",
	"INBOX"
);
$connection->connect();
```

#### Connection Options

```php
#~
```


### Mailboxes

Retrieve mailboxes (also known as mail folders) from the mail server and iterate over them:

```php
$mailbox = new Clivern\Imap\MailBox($connection);

$messages = $mailbox->getMessages();

foreach ($messages as $message) {
	echo "Subject: " . $message->header()->get('subject');
	echo "<br/>";
	echo $message->body()->getMessage();
}

```

#### Searching

To add custom search

```php
$search = new Clivern\Imap\Core\Search();
$search->addCondition(new Clivern\Imap\Core\Search\Condition\All());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Answered());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\BCC("filter@gmail.com"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Before(date("j F Y")));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Body("search text"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\CC("filter@gmail.com"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Deleted());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Flagged());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\From("filter@gmail.com"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Keyword("test"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\NewFlag());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Old());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\On(date("j F Y")));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Recent());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Seen());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Since(date("j F Y")));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Subject("search text"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\Text("search text"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\To("filter@gmail.com"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\UnAnswered());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\UnDeleted());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\UnFlagged());
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\UnKeyword("test"));
// $search->addCondition(new Clivern\Imap\Core\Search\Condition\UnSeen());

// For more info, please check http://php.net/manual/en/function.imap-search.php
```

Then configure mailbox:

```php
$mailbox = new Clivern\Imap\MailBox($connection);

$messages = $mailbox->getMessages($search);

foreach ($messages as $message) {
	echo "Subject: " . $message->header()->get('subject');
	echo "<br/>";
	echo $message->body()->getMessage();
}
```


#### Messages
```php
#~
```


Misc
====

Changelog
---------
Version 1.0.0:
```
Coming Soon
```

Acknowledgements
----------------

© 2017, Clivern. Released under the [MIT License](http://www.opensource.org/licenses/mit-license.php).

**Imap** is authored and maintained by [@clivern](http://github.com/clivern).