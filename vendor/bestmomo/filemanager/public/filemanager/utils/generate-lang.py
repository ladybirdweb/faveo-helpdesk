#!/usr/bin/python2.6


# Generate lang files with en.js file as reference
# if key does not exist in json file, the key and value are added from reference file (en.js)
# Usage : $ python ./utils/generate-lang.py


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

import os, io, json, codecs, sys

fmRootFolder = os.path.dirname(os.path.dirname(os.path.realpath(__file__))) + "/"

os.chdir(fmRootFolder + "scripts/languages/") # set working directory


filesList = list()

print bcolors.HEADER + "\nFiles to translate :"
print "-------------------------------------------\n" + bcolors.ENDC

for files in os.listdir("."):
    # we exclude 'en.js' file
    if files.endswith(".js") and files != 'en.js':
        filesList.append(files) # we populate filesList
        print bcolors.OKBLUE + files+ bcolors.ENDC # display file names

print bcolors.HEADER + "-------------------------------------------\n" + bcolors.ENDC


with open(fmRootFolder + "scripts/languages/" + 'en.js') as f:
    default_json = json.load(f)

# we loop on JS languages files
# if key does not exist in json file, the key and value are added from reference file (en.js)
for index, item in enumerate(filesList):
        # print index, item
        with open(fmRootFolder + "scripts/languages/" + item) as f:
            filename = fmRootFolder + "scripts/languages/"  + item
            print bcolors.OKGREEN +  str(index) + ") Writing file : " + filename + bcolors.ENDC
            current = json.load(f) # we get the current JSON file content
            
            # merging 2 dictionnaries
            data = dict(default_json.items() + current.items())

            # we calculate differences between lists
            diff = set(default_json.keys()) - set(current.keys())
            if len(diff)  == 0:
                print bcolors.OKBLUE + "... no keys added."+ bcolors.ENDC
            else:
                print bcolors.WARNING + "... keys " + bcolors.OKBLUE + ",".join(diff ) + bcolors.WARNING +" were added." + bcolors.ENDC

            # get a string with JSON encoding the list
            data = json.dumps(data)
            
            # we use codecs to keep utf-8 encoding without escaped \uXXXX
            filename = fmRootFolder + "scripts/languages/" + item
            file=codecs.open(filename, mode='w', encoding='utf-8')
            # magic happens here to make it pretty-printed
            file.write(json.dumps(json.loads(data), indent=4, sort_keys=True, ensure_ascii=False))
            file.close()
            
            print  bcolors.OKBLUE + "... file saved." + bcolors.ENDC
