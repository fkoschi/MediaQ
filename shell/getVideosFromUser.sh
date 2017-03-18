#!/bin/bash

#	Search for user generated videos
#	--------------------------------
#
#	If user has allready videos in his folder,
#	the filename will be saved into a variable.
#	
#	This variable is return value. On client side, 
#	we are going to use that variable to list all
#	the videos the user allready has generated.
#
#	Two options:
#	1)	download video
#	2)	watch video

#use facebook id to check on wether folder is there or not
DIRECTORY=$1

cd ../../videos/

if [ -d "$DIRECTORY" ]; then

	# change into that directory
	cd $DIRECTORY

	files_in_folder=$(ls -1)

	echo "${files_in_folder}"

fi