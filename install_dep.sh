#!/bin/bash
if [ ! -f /usr/local/bin/rar ]; then
    wget https://www.rarlab.com/rar/rarlinux-x64-5.8.b1.tar.gz
    tar -xzf rarlinux-x64-5.8.b1.tar.gz
    cd rar
    sudo make install
fi
