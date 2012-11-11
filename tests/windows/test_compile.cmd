@echo off
setlocal

set script_name=%0

:: Defaults
set def_portable=disabled
set def_smtube=enabled
set smtube_dir=..\..\smtube
set prefix_dir=%CD%\setup

set DEFS=
set SMTUBE_PARAMS=

:ARG_LOOP

if [%1]==[] (
	goto done
) else if [%1]==[-h] ( goto o_help
) else if [%1]==[--help] (
:o_help 
	echo Usage: %script_name% [OPTIONS]...
	echo.
	echo Configuration:
	echo   -h,  --help             display this help and exit
	echo   --disable-smtube        compile SMTube [enable]
	echo   --enable-portable       compile in portable mode [disable]
	echo.
	echo Installation directories:
  echo   --prefix=PREFIX         install architecture-independent files in PREFIX [%prefix_dir%]
	echo.
	echo Optional Packages:
	echo   --with-smtube=DIR       Prefix where SMTube sources are ^(optional^) [%smtube_dir%]
	echo.
	echo Note: Both SMPlayer and SMTube sources must be on the same partition as your compiler. You
	echo can use either relative paths or full paths.
	echo.
	goto exit

) else IF [%1]==[--enable-portable] (

	set DEFS="DEFINES+=PORTABLE_APP"
	set SMTUBE_PARAMS=pe
	set def_portable=enabled

) else IF [%1]==[--disable-smtube] (

	set def_smtube=disabled

) else IF [%1]==[--prefix] (

	set prefix_dir=%2
	shift
	
) else IF [%1]==[--with-smtube] (

	set smtube_dir=%2
	shift

) ELSE (

echo configure: error: unrecognized option: `%1'
echo Try `%script_name% --help' for more information
GOTO EXIT
) 
shift
GOTO ARG_LOOP
:done

echo SMPlayer will be built with the following options:
echo.
echo     Portable:     %def_portable%
echo     SMTube:       %def_smtube%
echo.
echo     SMTube source directory: %smtube_dir%
echo     Install prefix: %prefix_dir%
echo.

set /p debug="Debug; really continue with compile? [y/n] "
if [%debug%]==[n] goto exit

call getrev.cmd

if "%~1" == "pe" (
	echo Compiling SMPlayer Portable Edition
	echo.

)

cd zlib
mingw32-make -fwin32\makefile.gcc

cd ..\src
lrelease smplayer.pro
qmake %DEFS%
mingw32-make

if not [%def_smtube%]==[disabled] (
	if exist %smtube_dir%\compile_windows.cmd (

		cd %smtube_dir%
		compile_windows.cmd %SMTUBE_PARAMS%

	) else (

		echo SMTube not found in specified directory... skipping

	)
)
:exit
