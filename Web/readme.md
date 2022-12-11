# Brief Solution

## web01

## web02

## web03
1. Base 64 decode 2 times the cookie value.
2. Change the type to admin and encode again.
3. Exploit the type strcmp loose comparison  by changing password to password[] and get the flag.
## web04
1. user click on About and redirected to page.php?show=about.php
2. show parameter is vulnerable to local file inclusion
3. gain rce via [PHP filters](https://github.com/synacktiv/php_filter_chain_generator)
## web05

## web06
