#!/bin/bash

#
# install_hhvm_pgsql.sh
# ---------------------
# This script is intended to install hhvm-pgsql in hhvm testing environment
#

PWD=$(pwd)
BASE_DIR="$(cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"
SRC_DIR="$BASE_DIR/src"

echo
echo "Install PostgreSQL Extension for HHVM"
sudo apt-get install -y hhvm-dev

echo
HHVM_VERSION=$(php -r "echo preg_replace('/^(\d+\.\d+\.\d+)(.*?)$/', '\$1', HHVM_VERSION);")
HHVM_MAJOR_VERSION=$(php -r "echo preg_replace('/^(\d+\.\d+)(\.\d+)(.*?)$/', '\$1', HHVM_VERSION);")
echo "HHVM version: $HHVM_VERSION"

# clone the hhvm-pgsql
echo
echo "download hhvm-pgsql"
cd "$SRC_DIR"
git clone https://github.com/PocketRent/hhvm-pgsql.git
cd hhvm-pgsql
git fetch --tags

# Helps compile for hhvm 3.9
# Note: doesn't work. keep here and wait for later solution
#if [ "$HHVM_MAJOR_VERSION" == "3.9" ]; then
#  git checkout tags/3.7.2
#fi

echo
echo "compile and install hhvm-pgsql"
hphpize && \
cmake -DHACK_FRIENDLY=ON . && \
make && \
sudo mkdir -p /usr/lib/x86_64-linux-gnu/hhvm/extensions && \
sudo ln -s "$(pwd)/pgsql.so" /usr/lib/x86_64-linux-gnu/hhvm/extensions/pgsql.so && \
echo "hhvm.extensions[pgsql] = pgsql.so" >> /etc/hhvm/php.ini

# verify installation result
LOADED=$(hhvm --php -r 'echo extension_loaded("pdo_pgsql");')

if [ "$LOADED" == "1" ]; then
  echo
  echo "pdo_pgsql installation success"
  echo
  exit 0
fi

echo
echo "pdo_pgsql not loaded"
echo
echo "extension loaded:"
hhvm --php -r 'print_r(extension_loaded());'
echo
exit 1
