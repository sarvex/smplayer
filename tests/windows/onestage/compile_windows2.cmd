@echo off

set startdir=%CD%

set build_smtube=true
set build_pe=
set runinstcmd=

set smtube_params=
set qmake_defs=
set use_svn_revision=
set cpp_version=

for /f %%i in ("setup") do set build_prefix=%%~fi

:cmdline_parsing
if "%1" == ""               goto compile
if "%1" == "-h"             goto usage
if "%1" == "-prefix"        goto prefixTag
if "%1" == "-portable"      goto cfgPE
if "%1" == "-nosmtube"      goto cfgSmtube
if "%1" == "-noinst"        goto cfgInst

echo Unknown option: "%1"
echo.
goto usage

:usage
echo Usage: compile_windows2.cmd [-prefix (dir)]
echo                             [-nosmtube] [-portable] [-noinst]
echo.
echo Options:
echo   -h                     display this help and exit
echo.
echo   -prefix (dir)          prefix directory for installation 
echo                          (default prefix: %build_prefix%)
echo.
echo Miscellaneous options:
echo   -nosmtube              Do not compile SMTube
echo   -portable              Compile portable executables
echo.
echo   -noinst                Do not automatically install
echo.
goto end

:prefixTag

shift
set build_prefix=%1
shift

goto cmdline_parsing

:cfgPE

set qmake_defs=%qmake_defs% PORTABLE_APP
set build_pe=true
set smtube_params=pe
set runinstcmd=no
shift

goto cmdline_parsing

:cfgSmtube

set build_smtube=false
shift

goto cmdline_parsing

:cfgInst

set runinstcmd=no
shift

goto cmdline_parsing 

:compile

call getrev.cmd
call getwinvars.cmd

:: Get value of #define USE_SVN_VERSIONS
for /f "tokens=3" %%j in ('type src\version.cpp ^| find "USE_SVN_VERSIONS"') do set use_svn_revision=%%j

:: Get version from version.cpp
for /f "tokens=3" %%i in ('type src\version.cpp ^| find "#define VERSION"') do set CPP_VERSION=%%i

:: Remove quotes
SET CPP_VERSION=###%CPP_VERSION%###
SET CPP_VERSION=%CPP_VERSION:"###=%
SET CPP_VERSION=%CPP_VERSION:###"=%
SET CPP_VERSION=%CPP_VERSION:###=%

if [%use_svn_revision%]==[1] (

  echo set SMPLAYER_VERSION=%CPP_VERSION%.%REVISION%>>setup\scripts\win32inst_vars.cmd
  set qmake_defs=%qmake_defs% HAVE_SVN_REVISION_H

) else (

  echo set SMPLAYER_VERSION=%CPP_VERSION%>>setup\scripts\win32inst_vars.cmd

)

cd zlib
mingw32-make -fwin32\makefile.gcc

cd ..\src
lrelease smplayer.pro
qmake "DEFINES += %qmake_defs%"
mingw32-make

if [%build_smtube%]==[true] (
      cd %SMTUBE_DIR%
      call compile_windows.cmd %smtube_params%
)

if not [%runinstcmd%]==[no] (
  cd %startdir%\setup\scripts
  call install_smplayer2.cmd
)

if [%build_pe%]==[true] (
  if [%X86_64%]==[yes] (
    copy %SMTUBE_DIR%\src\release\smtube.exe %BUILD_PREFIX%\portable\smtube-portable64.exe
    copy %SMPLAYER_DIR%\src\release\smplayer.exe %BUILD_PREFIX%\portable\smplayer-portable64.exe
  ) else ( 
    copy %SMTUBE_DIR%\src\release\smtube.exe %BUILD_PREFIX%\portable\smtube-portable.exe
    copy %SMPLAYER_DIR%\src\release\smplayer.exe %BUILD_PREFIX%\portable\smplayer-portable.exe
  ) 
)
:: Return to starting directory
cd %startdir%

:end

:: Reset EVERYTHING
set startdir=
set build_smtube=
set build_pe=
set runinstcmd=
set smtube_params=
set qmake_defs=
set use_svn_revision=
set cpp_version=
