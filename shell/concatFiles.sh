#!/bin/bash

cd ../shell

INTERMEDIATE="$1intermediate/"
WORKINGFILES="$1workingfiles/"
VIDEOFILES="$1videofiles/"
FILENAME=$2

mkdir $INTERMEDIATE
chmod -R 775 $INTERMEDIATE
mkdir $WORKINGFILES
chmod -R 775 $WORKINGFILES
mkdir $VIDEOFILES
chmod -R 775 $VIDEOFILES

echo "Downloading of the files with another script"
bash ./downloadFiles.sh $VIDEOFILES

echo "Convert them to the same type"
bash ./convertToSameType.sh $VIDEOFILES

concat_string=""

videoArr=( `cat downloadPaths.txt `)
i=0

for f in "${videoArr[@]}"; do
   	arr=(${f//,/ })
	echo ${arr[0]}

	start=${arr[1]}
	duration=$((${arr[2]}-${arr[1]}))

	((millisec=(start/10)%1000, sec=(start/1000)%60 , min=((start/(1000*60)%60))))
	starttimestamp=$(printf "%d:%02d:%02d.%02d" 00 00 $sec $millisec)
	
	((millisec=(duration/10)%1000, sec=(duration/1000)%60 , min=((duration/(1000*60)%60))))
	durationtimestamp=$(printf "%d:%02d:%02d.%02d" 00 00 $sec $millisec)

	echo $starttimestamp
	echo $durationtimestamp

	first=${arr[0]}
	second=".mp4"
	first=${first/.mov/$second}

	echo $duration

	/usr/local/bin/ffmpeg -i "$VIDEOFILES$first" -ss $starttimestamp -vcodec copy -t $durationtimestamp "$WORKINGFILES$i.mp4" 2>&1
	/usr/local/bin/ffmpeg -i "$WORKINGFILES$i.mp4" "$INTERMEDIATE$i.mpg"
	
	((i=i+1))
done


filesInFolder=(`ls $INTERMEDIATE`)
	
for filename in "${filesInFolder[@]}"; do
	concat_string+="$INTERMEDIATE$filename|"
done

/usr/local/bin/ffmpeg -i concat:$concat_string "$WORKINGFILES$FILENAME.mpg"
/usr/local/bin/ffmpeg -i "$WORKINGFILES$FILENAME.mpg" "$1$FILENAME.mp4"
# /usr/local/bin/ffmpeg -i "$WORKINGFILES$FILENAME.mpg" -b 1500k -vcodec libvpx -acodec libvorbis -ab 160000 -f webm -g 30 -s 640x360 "$1$FILENAME.webm"
/usr/local/bin/ffmpeg -i "$WORKINGFILES$FILENAME.mpg"  -vcodec libtheora -acodec libvorbis -qscale 1 -ar 44100 -ab 128k -y "$1$FILENAME.ogg"

# ## WEBM:
# /usr/local/bin/ffmpeg -i "$WORKINGFILES$FILENAME.mpg" -vcodec libvpx -b:v 600k -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -vf scale=480:-1 -map 0 "$1$FILENAME.webm"
# ## MP4:
# /usr/local/bin/ffmpeg -i "$WORKINGFILES$FILENAME.mpg" -vcodec libx264 -b:v 600k -acodec libfdk_aac -ac 2 -ar 48000 -b:a 96k  -vf scale=480:-1 -map 0 "$1$FILENAME.mp4"
# ## OGV:
# /usr/local/bin/ffmpeg -i "$WORKINGFILES$FILENAME.mpg" -vcodec libtheora -b:v 600k -acodec libvorbis -b:a 96k -vf scale=480:-1 -map 0 "$1$FILENAME.ogv"

rm -rf $INTERMEDIATE
rm -rf $WORKINGFILES
rm -rf $VIDEOFILES

rm $FILENAME

#########################################################################################
#/usr/local/bin/ffmpeg -i concat:$concat_string -vcodec copy "$WORKINGFILES$filename.mpg"
#/usr/local/bin/ffmpeg -i "$WORKINGFILES$i.mp4" -qscale:v 1 "$INTERMEDIATE$i.mpg"
#/usr/local/bin/ffmpeg -i "$WORKINGFILES$i.mp4" -vcodec copy -acodec copy "$INTERMEDIATE$i.mpg"
#/usr/local/bin/ffmpeg -i "$WORKINGFILES$filename.mpg" -qscale:v 2 "$1$filename.mp4"
