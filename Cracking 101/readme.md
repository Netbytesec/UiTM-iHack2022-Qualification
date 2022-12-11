# Brief Solution

## AES
1. `bruteforce-salted-openssl -t 50 -f rockyou.txt flag.txt.enc -c aes-256-cbc -d sha256`
2. `openssl enc -aes-256-cbc -d -in flag.txt.enc`

## Password Recovery
`john --wordlist=rockyou.txt shadow.txt --format=crypt` 

## Forgotten Password
1. get the hash for password.kbdx and crack the master key. Use the master to get flag.
2. `hashcat -a 0 -m 13400 -o out.txt hash.txt /usr/share/wordlists/rockyou.txt`

## backup I
1. Challenge is about ZipCrypto exploit
2. Use bkcrack to solve the challenge (refer the tool tutorial: https://github.com/kimci86/bkcrack/blob/master/example/tutorial.md)

## backup II
1. Challenge is about ZipCrypto exploit
2. Use bkcrack to solve the challenge (refer the tool tutorial: https://github.com/kimci86/bkcrack/blob/master/example/tutorial.md)
