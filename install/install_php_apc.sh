#!/bin/bash

# this is helpful to compile extension
sudo apt-get install autoconf

echo $TRAVIS_PHP_VERSION

# install correct apcu extension with pecl
case "$TRAVIS_PHP_VERSION" in
  "5.5"|"5.6" )
    echo -e "yes\nyes" | pecl install apcu-4.0.11
    ;;
  "7.0"|* )
    #echo -e "yes\nyes" | pecl install apcu-5.1.5 apcu_bc-1.0.3

    # PHP7 apcu_bc has bug, abandon for now
    # early quit
    echo "PHP7 with APCu fails to install. Drop installation until fixed."
    exit 0
    ;;
esac

# enable CLI debug messages
echo apc.enable_cli=1 >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo

# test if the extension "apcu" is loaed correctly
LOADED=$(php -r 'echo extension_loaded("apcu");')
if [ "$LOADED" != "1" ]; then
    echo "x apcu not loaded"
    echo
    echo "extension loaded:"
    php -r 'print_r(extension_loaded());'
    echo
    exit 1
fi
echo "✓ apcu installation success"

# test if apc_* function exists in PHP environment
FUNCTION_EXISTS=$(php -r 'echo function_exists("apc_add");')
if [ "$FUNCTION_EXISTS" != "1" ]; then
  echo "x function apc_add not found in PHP environemnt"
  echo
  exit 1
fi
echo "✓ function apc_add found in PHP environemnt"

# all tests passed
echo
exit 0
