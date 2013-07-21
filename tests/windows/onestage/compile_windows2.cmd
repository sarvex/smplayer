@echo off

::                                       ::
::        Command-line Parsing           ::
::                                       ::

set start_dir=%~dp0

set build_smtube=true
set build_pe=
set runinstcmd=

set smtube_params=
set qmake_defs=
set use_svn_revision=

:: Default prefix
for /f %%i in ("setup") do set BUILD_PREFIX=%%~fi

:cmdline_parsing
if "%1" == ""               goto build_env_info
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
echo                             [-portable] [-nosmtube] [-noinst]
echo.
echo Configuration:
echo   -h                     display this help and exit
echo.
echo   -prefix (dir)          prefix directory for installation 
echo                          (default prefix: %build_prefix%)
echo.
echo Optional Features:
echo   -portable              Compile portable executables
echo   -nosmtube              Do not compile SMTube
echo.
echo Miscellaneous Options:
echo   -noinst                Do not run installation script
echo.
rem echo   -update                Update before compiling
rem echo.
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


::                                       ::
::        Build Environment Info         ::
::                                       ::

:build_env_info
set config_file=setup\scripts\win32inst_vars.cmd

:: GCC Target
for /f "usebackq tokens=2" %%i in (`"gcc -v 2>&1 | find "Target""`) do set gcc_target=%%i
if [%gcc_target%]==[x86_64-w64-mingw32] (
  set X86_64=yes
) else if [%gcc_target%]==[i686-w64-mingw32] (
  set X86_64=no
) else if [%gcc_target%]==[mingw32] (
  set X86_64=no
)

:: MinGW locations from GCC
for /f "usebackq tokens=1 delims=.." %%i in (`"gcc -print-search-dirs 2>&1 | find "install""`) do set MINGW_DIR=%%i
for /f "tokens=2 delims= " %%i in ("%MINGW_DIR%") do set MINGW_DIR=%%i
if %MINGW_DIR:~-1%==\ set MINGW_DIR=%MINGW_DIR:~0,-1%

:: Qt locations from QMAKE
for /f "tokens=*" %%i in ('qmake -query QT_INSTALL_PREFIX') do set QT_DIR=%%i
for /f "tokens=*" %%i in ('qmake -query QT_VERSION') do set QT_VER=%%i

set SMPLAYER_DIR=%start_dir%
:: Does string have a trailing slash? if so remove it 
if %SMPLAYER_DIR:~-1%==\ set SMPLAYER_DIR=%SMPLAYER_DIR:~0,-1%

:: Using the \trunk (whole repo checked out as a whole or checked out separately)? 
for %%a in ("%cd%") do set trunk_dir=%%~nxa

if [%trunk_dir%]==[trunk] (
  set svn_topdir=..\..
  set svn_trunkdir=\trunk
) else (
  set svn_topdir=..
  set svn_trunkdir=
)

for /f %%i in ("%svn_topdir%\smtube%svn_trunkdir%") do set SMTUBE_DIR=%%~fi
for /f %%i in ("%svn_topdir%\smplayer-themes%svn_trunkdir%") do set SMPLAYER_THEMES_DIR=%%~fi
for /f %%i in ("%svn_topdir%\smplayer-skins%svn_trunkdir%") do set SMPLAYER_SKINS_DIR=%%~fi

:: Create var batch file
echo set SMPLAYER_DIR=%SMPLAYER_DIR%>%config_file%
echo set SMTUBE_DIR=%SMTUBE_DIR%>>%config_file%
echo set SMPLAYER_THEMES_DIR=%SMPLAYER_THEMES_DIR%>>%config_file%
echo set SMPLAYER_SKINS_DIR=%SMPLAYER_SKINS_DIR%>>%config_file%
echo set QT_DIR=%QT_DIR%>>%config_file%
echo set QT_VER=%QT_VER%>>%config_file%
echo set MINGW_DIR=%MINGW_DIR%>>%config_file%
echo set X86_64=%X86_64%>>%config_file%
echo set BUILD_PREFIX=%BUILD_PREFIX%>>%config_file%

::                                       ::
::          Main Compile Script          ::
::                                       ::

call getrev.cmd

:: Get value of #define USE_SVN_VERSIONS
for /f "tokens=3" %%j in ('type src\version.cpp ^| find "USE_SVN_VERSIONS"') do set use_svn_revision=%%j

if [%use_svn_revision%]==[1] (
  set qmake_defs=%qmake_defs% HAVE_SVN_REVISION_H
)

cd dxlist
for %%F in (directx\d3dtypes.h directx\ddraw.h directx\dsound.h) do if not exist %%F goto skip_dxlist
qmake
mingw32-make
:skip_dxlist

cd ..\zlib
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
  cd %SMPLAYER_DIR%\setup\scripts
  call install_smplayer2.cmd
)

if [%build_pe%]==[true] (
  mkdir %BUILD_PREFIX%\portable

  if [%X86_64%]==[yes] (
    copy /y %SMTUBE_DIR%\src\release\smtube.exe %BUILD_PREFIX%\portable\smtube-portable64.exe
    copy /y %SMPLAYER_DIR%\src\release\smplayer.exe %BUILD_PREFIX%\portable\smplayer-portable64.exe
  ) else ( 
    copy /y %SMTUBE_DIR%\src\release\smtube.exe %BUILD_PREFIX%\portable\smtube-portable.exe
    copy /y %SMPLAYER_DIR%\src\release\smplayer.exe %BUILD_PREFIX%\portable\smplayer-portable.exe
  )
)
:: Return to starting directory
cd %start_dir%

:end

:: Reset
set startdir=
set build_smtube=
set build_pe=
set runinstcmd=
set smtube_params=
set qmake_defs=
set use_svn_revision=

set svn_topdir=
set svn_trunkdir=
