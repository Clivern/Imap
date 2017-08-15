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

use Clivern\Imap\Core\Connection;

$connection = new Connection(
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
use Clivern\Imap\MailBox;

$mailbox = new MailBox($connection);

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
use Clivern\Imap\Core\Search;
use Clivern\Imap\Core\Search\Condition\All;
use Clivern\Imap\Core\Search\Condition\Answered;
use Clivern\Imap\Core\Search\Condition\BCC;
use Clivern\Imap\Core\Search\Condition\Before;
use Clivern\Imap\Core\Search\Condition\Body;
use Clivern\Imap\Core\Search\Condition\CC;
use Clivern\Imap\Core\Search\Condition\Deleted;
use Clivern\Imap\Core\Search\Condition\Flagged;
use Clivern\Imap\Core\Search\Condition\From;
use Clivern\Imap\Core\Search\Condition\Keyword;
use Clivern\Imap\Core\Search\Condition\NewFlag;
use Clivern\Imap\Core\Search\Condition\Old;
use Clivern\Imap\Core\Search\Condition\On;
use Clivern\Imap\Core\Search\Condition\Recent;
use Clivern\Imap\Core\Search\Condition\Seen;
use Clivern\Imap\Core\Search\Condition\Since;
use Clivern\Imap\Core\Search\Condition\Subject;
use Clivern\Imap\Core\Search\Condition\Text;
use Clivern\Imap\Core\Search\Condition\To;
use Clivern\Imap\Core\Search\Condition\UnAnswered;
use Clivern\Imap\Core\Search\Condition\UnDeleted;
use Clivern\Imap\Core\Search\Condition\UnFlagged;
use Clivern\Imap\Core\Search\Condition\UnKeyword;
use Clivern\Imap\Core\Search\Condition\UnSeen;

$search = new Search();
$search->addCondition(new All());
// $search->addCondition(new Answered());
// $search->addCondition(new BCC("filter@gmail.com"));
// $search->addCondition(new Before(date("j F Y")));
// $search->addCondition(new Body("search text"));
// $search->addCondition(new CC("filter@gmail.com"));
// $search->addCondition(new Deleted());
// $search->addCondition(new Flagged());
// $search->addCondition(new From("filter@gmail.com"));
// $search->addCondition(new Keyword("test"));
// $search->addCondition(new NewFlag());
// $search->addCondition(new Old());
// $search->addCondition(new On(date("j F Y")));
// $search->addCondition(new Recent());
// $search->addCondition(new Seen());
// $search->addCondition(new Since(date("j F Y")));
// $search->addCondition(new Subject("search text"));
// $search->addCondition(new Text("search text"));
// $search->addCondition(new To("filter@gmail.com"));
// $search->addCondition(new UnAnswered());
// $search->addCondition(new UnDeleted());
// $search->addCondition(new UnFlagged());
// $search->addCondition(new UnKeyword("test"));
// $search->addCondition(new UnSeen());

// For more info, please check http://php.net/manual/en/function.imap-search.php
```

Then configure mailbox:

```php
use Clivern\Imap\MailBox;

$mailbox = new MailBox($connection);

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