#!/bin/bash
read -p "File che deve restare: " file
find . -type f -not \( -name "pear" -o -name "xdebug_remote.log" -o -name "$file" -o -name "cancella.sh" \) -exec rm {} \;