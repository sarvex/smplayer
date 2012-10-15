cd getrev
mingw32-make distclean

cd ..\zlib
mingw32-make -fwin32\makefile.gcc clean

cd ..\src
mingw32-make distclean

cd ..

del src\translations\umplayer_*.qm
del src\object_script.umplayer.Release
del src\object_script.umplayer.Debug
del src\svn_revision.h
rd src\release
rd src\debug
