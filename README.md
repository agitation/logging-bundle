**Agitation** is an e-commerce framework, based on Symfony2, focussed on
extendability through plugged-in APIs, UIs, payment modules and other
components.

## AgitLoggingBundle

This bundle provides a simple DB-based logger. It records log messages on the
application level and is to be used by end users of the application in question.

We don’t use Monolog here on purpose: We log to the database, and our log
records look different than what Monolog as a PSR-compliant logger offers.

However, severe log entries are also written to the global `@logger` service,
so we can be sure they will also show up in Symfony’s log file.
