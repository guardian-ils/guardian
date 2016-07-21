#!/usr/bin/env bash

echo "Install PostgreSQL Extension for HHVM" && \
apt-get install -y hhvm-dev cmake make g++ && \
git clone https://github.com/PocketRent/hhvm-pgsql.git && \
cd hhvm-pgsql && \
hphpize && \
cmake -DHACK_FRIENDLY=ON . && \
make && \
ln -s /usr/lib/x86_64-linux-gnu/hhvm/extensions/pgsql.so "$(pwd)/pgsql.so" && \
echo "hhvm.extensions[pgsql] = pgsql.so" >> /etc/hhvm/php.ini