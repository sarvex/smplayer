set olddir=%CD%

cd dxlist
mingw32-make distclean

cd ..\zlib
mingw32-make -fwin32\makefile.gcc clean

cd ..\src
mingw32-make distclean

cd ..
del setup\scripts\win32inst_vars.cmd
del src\translations\smplayer_*.qm
del src\object_script.smplayer.Release
del src\object_script.smplayer.Debug
del src\svn_revision.h
rd dxlist\release
rd dxlist\debug
rd src\release
rd src\debug

if exist ..\smtube\clean_windows.cmd (

  cd ..\smtube
  clean_windows.cmd
  :: Return to original directory
  cd %olddir%

) else (

  echo SMTube not found in specified directory... skipping

)
