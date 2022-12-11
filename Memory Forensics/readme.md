# Brief Solution

Download the memory dump file here: 
https://drive.google.com/file/d/1gE2LsgBCuobTCs2p-4Uag9WEXqP9-gLM/view?usp=sharing

## I
### Provide the md5 hash of the memory image as the flag. Flag format: ihack{MD5}

- Command: md5sum artefact.vmem
- answer: 2aff5e0bd33f622790c3db33f0798978  
- flag: ihack{2aff5e0bd33f622790c3db33f0798978}

## II
### There is an incident that happens. The SOC team has performed the memory dump on that infected PC. Based on the memory dump file, identify the suspicious process name used by the attacker. Flag format : ihack{name.ext}
![image](https://user-images.githubusercontent.com/62234787/206900723-aaf9dc56-41e7-4271-9c9e-b95db95fb1c9.png)
- command: volatility -f artefact.vmem --profile=Win7SP1x86 pslist
- answer: putty.exe
- flag: ihack{putty.exe}

## III
### Identify process ID (PID) of the suspicious process. Flag format: ihack{PID}
![image](https://user-images.githubusercontent.com/62234787/206900819-8837b12d-5994-4ec7-ae6c-bfc5f9b82ba8.png)
- command: volatility -f artefact.vmem --profile=Win7SP1x86 pslist
- answer: 1732
- flag: ihack{1732}

## IV
### SOC analyst confirm that the infected PC make an connection to the IP address of C2's attacker. Identify the IP address that connected to the C2's attacker. Flag format: ihack{IP}
![image](https://user-images.githubusercontent.com/62234787/206900917-66210d85-0897-4e90-8b2d-63eb7ca88565.png)
since the question ask for network connection, we can verify from the network statistic result. Look for the suspicious connection from the network perspective. 
- command: volatility -f artefact.vmem --profile=Win7SP1x86 netscan
- answer: 139.59.122.20
- flag: ihack{139.59.122.20}

## V
### There is an additional user in the compromised host created by the attacker. Can you spot the created user within this given memory dump file? Flag format: ihack{username}
The question ask for what is the user created in the host. Detail information can be gain from event log. To dump the event log, can use tool from https://github.com/williballenthin/EVTXtract. 
![image](https://user-images.githubusercontent.com/62234787/206902383-dd8e06c6-ac0c-447a-a7fb-8094a8e33134.png)

Solution (use tool evtxtract(https://github.com/williballenthin/EVTXtract))
- Noted that all the action/event in the Windows environment recorded in the event log. Noted that when we investigate the event user created, it related to event id 4720 in Event log of the windows. It recorded on Security Event Logs. 

Other alternative, we can dump the memory resident for that process, since we confirm that the process putty make an connection to the attacker IP. Result from memdump plugin, we got the info that attacker create user (sysadmin) and add user (sysadmin) in group (Remote Desktop Users)
![image](https://user-images.githubusercontent.com/62234787/206902461-12182322-8175-4f7f-adc3-19c45c55710a.png)

Solution (use volatility)
- command: volatility -f artefact.vmem --profile=Win7SP1x86 memdump -p 1732 -D /dump | strings dump/1732.dmp
- answer: sysadmin
- flag: ihack{sysadmin}

## VI

## VII
