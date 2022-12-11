# Brief Solution

## DFIR 1
1. Follow TCP streams and extract using Wireshark. Need to remove garbage char in the extracted file.
2. OR Extract using network miner
3. md5sum PHP file = `8472a0454391a40792173708866514ef`

## DFIR 2
Open the [threat.zip](https://github.com/Netbytesec/UiTM-iHack2022-Qualification/blob/main/Incident%20Response%20and%20Forensics/DFIR%202/threat.zip) file (d5b70c8bf56aca91acd4754739b44df2), and you'll get access.log file

1. Upon opening the access.log file, you'll find some encoded payload in script tag
    - from here, you know it was from access.log
    - you know it was javascript
    - you know it was encoded
2. Hence you need to URL decode it first, but bear in mind, space in URL is `%20` but not `+`, so you need to include the + & not decode it
    - you need to also take note that, "/" was encoded as "//" in the payload
    - so you need to properly decode it from URL encode payload
3. Once you've done decoding it from URL, you need to identify what kind of encoding for the javascript,
    - as for this case, we used [jjencode](https://pferrie2.tripod.com/papers/jjencode.pdf) 
4. decoding with (https://www.53lu.com/tool/jjencode/) will provide you the flag
    - you can also use [nodejs](https://www.w3schools.com/nodejs/nodejs_intro.asp) to solve it

## DFIR 3
1. Given NTUSER.dat artifact, analyze the file with Registry Explorer.
2. The description told about persistent mechanism.
3. Registry persistent mechanism is located at Software\Microsoft\Windows\CurrentVersion\Run

## DFIR 4
1. Scroll the log until you see a malicious powershell script execution
2. Reading the script will reveal the file that was using by the malware which is `a.jsp`

## DFIR 5
1. Challenges is about WMI persistence
2. Parse the OBJECTS.DATA using PyWMIPersistenceFinder.py
3. Flag would be `svchostss.exe`
