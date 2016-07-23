#!/usr/bin/env bash

echo "Install PostgreSQL Extension for HHVM" && \
add-apt-repository -y ppa:george-edison55/cmake-3.x && \
apt-get update && \
apt-get -y upgrade && \
apt-get install -y hhvm-dev cmake build-essential && \
g++ --version && \
cmake --version && \
git clone https://github.com/PocketRent/hhvm-pgsql.git && \
cd hhvm-pgsql && \
hphpize && \
cmake -DHACK_FRIENDLY=ON . && \
make && \
ln -s "$(pwd)/pgsql.so" /usr/lib/x86_64-linux-gnu/hhvm/extensions/pgsql.so && \
echo "hhvm.extensions[pgsql] = pgsql.so" >> /etc/hhvm/php.ini
