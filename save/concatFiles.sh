#!/bin/bash

echo "Downloading of the files with another script"
sh /Applications/MAMP/htdocs/MediaQ/shell/downloadFiles.sh

echo "Convert them to the same type"
sh /Applications/MAMP/htdocs/MediaQ/shell/convertToSameType.sh


concat_string=""

videoArr=( `cat "downloadPaths.txt" `)
i=0
for f in "${videoArr[@]}"; do
   	arr=(${f//,/ })
	echo ${arr[0]}

	echo "Cut file ${arr[1]}"
	/usr/local/bin/ffmpeg -i "/Applications/MAMP/htdocs/MediaQ/php/videofiles/${arr[0]}" -ss 00:00:30.0 -c copy -t 00:00:10.0 "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/$i.mp4" 2>&1

   	/usr/local/bin/ffmpeg -i "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/$i.mp4" -qscale:v 1 "/Applications/MAMP/htdocs/MediaQ/php/intermediate/intermediate_$i.mpg"

	((i=i+1))
done

<<<<<<< HEAD
for filename in "${videoArr[@]}"; do
	
	lengthOfVideo="$((${arr[1]}+${arr[2]}))"

   	echo "Cut file $filename to snippet from $starttime with length of $endtime"
   	/usr/local/bin/ffmpeg -i "/Applications/MAMP/htdocs/MediaQ/php/videofiles/${arr[0]}" -ss 00:00:30.0 -c copy -t 00:00:10.0 "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/cut_${arr[0]}" 2>&1

    # echo "convert file $filename in intermediate file"
   	# /usr/local/bin/ffmpeg -i "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/cut_${arr[0]}" -qscale:v 1 "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/intermediate_${arr[0]}.mpg"
=======
filesInFolder=(`ls /Applications/MAMP/htdocs/MediaQ/php/intermediate`)

for filename in "${filesInFolder[@]}"; do
   	concat_string+="/Applications/MAMP/htdocs/MediaQ/php/intermediate/$filename|"
>>>>>>> branch 'master' of https://reisingerm@bitbucket.org/mediaqteamb/origin.git
done

echo $concat_string

/usr/local/bin/ffmpeg -i concat:$concat_string -c copy "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/intermediate_all.mpg"
/usr/local/bin/ffmpeg -i "/Applications/MAMP/htdocs/MediaQ/php/workingfiles/intermediate_all.mpg" -qscale:v 2 "/Applications/MAMP/htdocs/MediaQ/php/finalfiles/$(date +%Y%m%d%H%M%S).mp4"

# # current_dir=$(pwd)
# # script_dir=$(/workingfiles $0)

# # echo $current_dir
# # echo $script_dir

rm -rfv /Applications/MAMP/htdocs/MediaQ/php/workingfiles/*
rm -rfv /Applications/MAMP/htdocs/MediaQ/php/videofiles/*
rm -rfv /Applications/MAMP/htdocs/MediaQ/php/intermediate/*

# open('downloadPaths.txt', 'w').close()




