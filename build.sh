#!/usr/bin/env sh

if [ -d build ]; then
  rm -r build
fi

mkdir -p build/slowfetch
mkdir -p build/slowfetch/DEBIAN

mkdir -p build/slowfetch/usr/local/bin && cp slowfetch build/slowfetch/usr/local/bin/
mkdir -p build/slowfetch/opt/slowfetch
cp index.php build/slowfetch/opt/slowfetch
cp Ansi.php build/slowfetch/opt/slowfetch

touch build/slowfetch/DEBIAN/control

cat control-template.txt > build/slowfetch/DEBIAN/control

dpkg-deb --build build/slowfetch