#!/usr/bin/python2.6

# Minify Filemanager javascript files 
# Usage : $ python ./utils/minify.py

class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'

    def disable(self):
        self.HEADER = ''
        self.OKBLUE = ''
        self.OKGREEN = ''
        self.WARNING = ''
        self.FAIL = ''
        self.ENDC = ''

import httplib, urllib, sys, os


fmRootFolder = os.path.dirname(os.path.dirname(os.path.realpath(__file__))) + "/"

os.chdir(fmRootFolder + "scripts/") # set working directory

toMinify = ["scripts/filemanager.js", "scripts/filemanager.liveSearch.js"]

print bcolors.HEADER + "-------------------------------------" + bcolors.ENDC

# we loop on JS languages files
for index, item in enumerate(toMinify):
	# print index, item
	
	dir = os.path.dirname(item)
	file = os.path.basename(item)
	
	with open (fmRootFolder + item, "r") as myfile:
	        js_input=myfile.read()

	        # Define the parameters for the POST request and encode them in
	        # a URL-safe format.

	        params = urllib.urlencode([
	        ('js_code', js_input),
	        #   ('compilation_level', 'WHITESPACE_ONLY'),
	        ('compilation_level', 'SIMPLE_OPTIMIZATIONS'),
	        ('output_format', 'text'),
	        ('output_info', 'compiled_code'),
	        ])

	        params2 = urllib.urlencode([
	        ('js_code', js_input),
	        #   ('compilation_level', 'WHITESPACE_ONLY'),
	        ('compilation_level', 'SIMPLE_OPTIMIZATIONS'),
	        ('output_format', 'text'),
	        ('output_info', 'errors'),
	        ])

	        # Always use the following value for the Content-type header.
	        headers = { "Content-type": "application/x-www-form-urlencoded" }
	        conn = httplib.HTTPConnection('closure-compiler.appspot.com')
	        conn.request('POST', '/compile', params, headers)
	        response = conn.getresponse()
	        data = response.read()

	        # we write the minified file - os.path.splitext(file)[0]  return filename without extension
	        with open(fmRootFolder + dir + '/' + os.path.splitext(file)[0] + ".min.js", "w") as text_file:
	                text_file.write(data)

	        # We retrieve errors
	        conn.request('POST', '/compile', params2, headers)
	        response = conn.getresponse()
	        errors = response.read()

	        
	        if errors == "":
	        	        print bcolors.OKBLUE + file + " has been minified. No error found."
	        else:
	        	        print bcolors.FAIL + file + " : the code contains errors : "
	        	        print ""
	        	        print errors + bcolors.ENDC

	        conn.close()

print bcolors.HEADER + "-------------------------------------" + bcolors.ENDC
