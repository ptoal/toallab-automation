#!/bin/bash

WATERFALL_DIR=/var/games/waterfall

if [ -f /var/games/minecraft/.shutdown_mc ]; then
  exit 1
fi

# Is Process running?
ps -ef | grep -v grep | grep -q Waterfall.jar
if [ $? -eq 1 ]; then
  echo "Waterfall not running. Restarting... "  |  /bin/mail -s "Server Restart - WATERFALL"  ptoal@takeflight.ca
  cd $WATERFALL_DIR && tmux new-session -d -s waterfall /usr/games/waterfall/run_waterfall.sh
fi