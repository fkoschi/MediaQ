#!/bin/bash

#1) check if folder exists for user id
#
#	yes
#		-> new folder for new video
#
#	no 
#		-> new folder for user 


# get facebook user id and set it for the directory path
DIRECTORY=$1

#switch to right folder path
cd ../../videos

# check if path exists
if [ -d "$DIRECTORY" ]; then
	# path exists
	echo "directory found"
	# change into that directory
	cd $DIRECTORY
else 
	# path does not exist
	echo "directory not found"
	# add this new directory
	mkdir $DIRECTORY
	chmod -R 775 $DIRECTORY
	# switch into that directory
	cd $DIRECTORY
fi
