#!/bin/bash

VideoID=( `cat downloadPaths.txt `)

# move to folder where we need videos
pwd
cd $1
pwd

for f in "${VideoID[@]}"; do
   	arr=(${f//,/ })

	if [ ! -f "${arr[0]}" ]; then
		wget http://mediaq.dbs.ifi.lmu.de/MediaQ_MVC_V2/video_content/${arr[0]}
	fi
done

# ---------

#copy files from directory in our directory

