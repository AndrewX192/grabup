#!/bin/bash

# Takes a screenshot and uploads it to a remote location.
#
# Grabup for Linux
# @author Andrew Sorensen <andrew@localcoast.net>
#
# Distribution or modification of this file is premitted so long as
# This header remains intact

# === CONFIGURATION OPTIONS ===

# Where should the grabups be stored?
LOCAL_GRABS=~/.Applications/grabup # make sure that this exists!
GRAB_NAME=`date +%s`
HOST='grabup.example.com'
ADDSHADOW=true
SHORTENURL=false

# === END CONFIGURATION OPTIONS ===

cd $LOCAL_GRABS
filename=`date +%s`

# take the screenshot.
scrot -s -b $GRAB_NAME.png

if [ ! -f $GRAB_NAME.png ]; then
    exit 1
fi

# shadows
if $ADDSHADOW; then
    convert $GRAB_NAME.png -gravity northwest -background 'rgba(255,255,255,0)' -splice 10x10 \
    \( +clone -background gray -shadow 80x12-1-1 \) +swap -background none -mosaic +repage \
    \( +clone -background gray -shadow 80x12+5+5 \) +swap -background none -mosaic +repage $GRAB_NAME.png
fi

# upload
curl -F file=@$filename.png -F press="OK" http://$HOST/post_upload.php

# shortening
URL="http://$HOST/$GRAB_NAME"
if $SHORTENURL; then
    URL="http://is.gd/api.php?longurl=$URL"
    URL=`curl $URL`
fi

# copy to clipboard
echo "$URL" | xclip

# notifications
notify-send "Your screenshot has now been uploaded to $URL"
