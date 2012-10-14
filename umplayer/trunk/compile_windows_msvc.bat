cd getrev
qmake
jom

cd ..

getrev\release\getrev.exe > src\svn_revision.h

cd src
lrelease smplayer.pro
qmake
jom
