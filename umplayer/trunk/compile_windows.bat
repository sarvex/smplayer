cd getrev
qmake
mingw32-make 
cd ..

getrev\release\getrev.exe > src\svn_revision.h

cd zlib
mingw32-make -fwin32\makefile.gcc
cd ..

cd src
lrelease umplayer.pro
qmake
mingw32-make
cd ..
