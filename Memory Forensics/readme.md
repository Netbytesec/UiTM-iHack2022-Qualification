# Brief Solution

Download the memory dump file here: 
https://drive.google.com/file/d/1gE2LsgBCuobTCs2p-4Uag9WEXqP9-gLM/view?usp=sharing

## I
### Provide the md5 hash of the memory image as the flag. Flag format: ihack{MD5}

Command: `md5sum artefact.vmem`
answer: 2aff5e0bd33f622790c3db33f0798978  
flag: ihack{2aff5e0bd33f622790c3db33f0798978}

## II
### There is an incident that happens. The SOC team has performed the memory dump on that infected PC. Based on the memory dump file, identify the suspicious process name used by the attacker. Flag format : ihack{name.ext}
![image](https://user-images.githubusercontent.com/62234787/206900723-aaf9dc56-41e7-4271-9c9e-b95db95fb1c9.png)
- command: `volatility -f artefact.vmem --profile=Win7SP1x86 pslist`
- answer: putty.exe
- flag: ihack{putty.exe}

## III
### Identify process ID (PID) of the suspicious process. Flag format: ihack{PID}

command: `volatility -f artefact.vmem --profile=Win7SP1x86 pslist`
answer: 1732
flag: ihack{1732}

## IV

## V

## VI

## VII
