#!/bin/bash

# move to folder where we need videos
pwd
cd $1
pwd

videoArr=(`ls`)

for filename in "${videoArr[@]}"; do

	if [[ $filename == *.mov ]]
		then
		withoutExt="${filename%.*}"
		echo "$withoutExt"

		/usr/local/bin/ffmpeg -i $filename -vcodec copy -acodec copy $withoutExt.mp4
		rm $filename
	fi

done