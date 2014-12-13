@echo off

::                                       ::
::        Command-line Parsing           ::
::                                       ::

set start_dir=%~dp0

set build_pe=
set runinstcmd=
set runsvnup=yes
set runnsiscmd=yes
set qmake_defs=

set config_file=setup\scripts\win32inst_vars.cmd

:: Default prefix
for /f %%i in ("setup") do set BUILD_PREFIX=%%~fi

:cmdline_parsing
if "%1" == ""               goto build_env_info
if "%1" == "-h"             goto usage
if "%1" == "-prefix"        goto prefixTag
if "%1" == "-portable"      goto cfgPE
if "%1" == "-noupdate"      goto cfgUpdate


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
echo.
echo Miscellaneous Options:
echo   -noinst                Do not run installation script
echo   -noupdate              Do not update before compiling
echo.
goto end

:prefixTag

shift
set build_prefix=%1
shift

goto cmdline_parsing

:cfgPE

set qmake_defs=%qmake_defs% PORTABLE_APP
set build_pe=yes
set runinstcmd=no
shift

goto cmdline_parsing

:cfgInst

set runinstcmd=no
shift

goto cmdline_parsing

:cfgUpdate
set runsvnup=no
shift

goto cmdline_parsing

::                                       ::
::        Build Environment Info         ::
::                                       ::

:build_env_info

:: GCC Target
for /f "usebackq tokens=2" %%i in (`"gcc -v 2>&1 | find "Target""`) do set gcc_target=%%i
if [%gcc_target%]==[x86_64-w64-mingw32] (
  set X86_64=yes
) else if [%gcc_target%]==[i686-w64-mingw32] (
  set X86_64=no
) else if [%gcc_target%]==[mingw32] (
  set X86_64=no
)

if [%runsvnup%]==[yes] (
  svn up
  echo.
)

set SMTUBE_DIR=%start_dir%
:: Does string have a trailing slash? if so remove it 
if %SMTUBE_DIR:~-1%==\ set SMTUBE_DIR=%SMTUBE_DIR:~0,-1%

rem echo set SMTUBE_DIR=%SMTUBE_DIR%>>%config_file%
rem echo set X86_64=%X86_64%>>%config_file%
rem echo set BUILD_PREFIX=%BUILD_PREFIX%>>%config_file%

:compile

call getrev.cmd

cd src
lrelease smtube.pro
qmake "DEFINES += %qmake_defs%"
mingw32-make

:: Installation
if not [%runinstcmd%]==[no] (
  mkdir %BUILD_PREFIX%\smtube-build
  copy %SMTUBE_DIR%\src\release\smtube.exe %BUILD_PREFIX%\smtube-build

  mkdir %BUILD_PREFIX%\smtube-build\translations
  copy %SMTUBE_DIR%\src\translations\*.qm %BUILD_PREFIX%\smtube-build\translations

  mkdir %BUILD_PREFIX%\smtube-build\docs\smtube
  copy %SMTUBE_DIR%\*.txt %BUILD_PREFIX%\smtube-build\docs\smtube

  if not [%runnsiscmd%]==[no] (\
    mkdir %SMTUBE_DIR%\setup\output
    call %SMTUBE_DIR%\setup\scripts\make_pkgs.cmd -1
  )

)

if [%build_pe%]==[yes] (
  mkdir %BUILD_PREFIX%\portable

  if [%X86_64%]==[yes] (
    copy /y release\smtube.exe %BUILD_PREFIX%\portable\smtube-portable64.exe
  ) else ( 
    copy /y release\smtube.exe %BUILD_PREFIX%\portable\smtube-portable.exe
  )
)
:: Return to starting directory
cd %start_dir%

call clean_windows.cmd

:end