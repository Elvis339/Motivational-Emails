#!/bin/bash

directory=`dirname $0`
cd $directory
directory=`pwd`

(crontab -l ; echo "0 12 * * 1-5 cd $directory && /usr/bin/php src/Main.php") | crontab -

echo "Crontab setup successfully"