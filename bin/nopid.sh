#!/bin/bash
$1 >> /tmp/rt-$2-rto.txt 2>&1 & 
echo $!
