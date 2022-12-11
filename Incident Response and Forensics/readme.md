# Brief Solution

## DFIR 1

## DFIR 2
Open the [threat.zip](https://github.com/Netbytesec/UiTM-iHack2022-Qualification/blob/main/Incident%20Response%20and%20Forensics/DFIR%202/threat.zip) file (d5b70c8bf56aca91acd4754739b44df2), and you'll get access.log file

1. Upon opening the access.log file, you'll find some encoded payload in script tag
    - from here, you know it was from access.log
    - you know it was javascript
    - you know it was encoded
2. Hence you need to URL decode it first, but bear in mind, space in URL is %20 but not +, so you need to include the + and not decode it
    - you need to also take note that, "/" was encoded as "//" in the payload
    - so you need to properly decode it from URL encode payload
3. Once you've done decoding it from URL, you need to identify what kind of encoding for the javascript,
    - as for this case, we used [jjencode](https://pferrie2.tripod.com/papers/jjencode.pdf) 
4. decoding with (https://www.53lu.com/tool/jjencode/) will provide you the flag
    - you can also use [nodejs](https://www.w3schools.com/nodejs/nodejs_intro.asp) to solve it

## DFIR 3

## DFIR 4

## DFIR 5
