from flask import Flask, request, render_template
from urllib.parse import urlparse
import dns.resolver
import os
import requests
import re
import validators
import tldextract

app = Flask(__name__)

def checkIP(url):
    # extract domain
    parsed_uri = urlparse(url).netloc
    # check valid URL scheme
    match = re.match(r"[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", parsed_uri)
    
    if not match:
        try:
            # get domain name without subdomain
            extracted = tldextract.extract(parsed_uri)
            domain = "{}.{}".format(extracted.domain, extracted.suffix)
            # request DNS records
            answers = dns.resolver.resolve(domain, 'NS')

            if answers:
                return True
            else:
                return False
        except:
            return False

def validateURL(url):
    validate = validators.url(url, public=True)

    if validate:
        if checkIP(url):
            return True
        else:
            return False
    else:
        return False

@app.route('/', methods=['GET', 'POST'])
def index():

    if request.method == 'POST':
        url = request.form['url']
        
        if validateURL(url):
            try:
                headers = {
                    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36'
                }

                r = requests.get(url, headers=headers)

                return render_template('index.html', result=r.text)
            except:
                return render_template('index.html', error=f"There is an error to make requets!")
        else:
            return render_template('index.html', error=f"It seems like this system cannot handle your URL!")

    return render_template('index.html')


@app.route('/flag')
def flag():
    if request.remote_addr == '127.0.0.1':
        return render_template('flag.html', FLAG=os.environ.get("FLAG"))

    else:
        return render_template('forbidden.html'), 403


if __name__ == '__main__':
    app.run(host="0.0.0.0", port=8081, threaded=True)

