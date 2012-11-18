@echo off
setlocal

set script_name=%0

:: Defaults
set def_portable=disabled
set def_smtube=enabled
set smtube_dir=..\..\smtube
set prefix_dir=%CD%\setup

set QMAKE_DEFS=
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
	echo.
	echo Optional features:
	echo   --enable-portable         enable portable mode [disable]
	echo   --disable-smtube          enable SMTube [enable]
	REM echo   --disable-single-inst     disable support for running a single instance [enable]
	REM echo   --disable-findsubs        disable opensubtitles.org subtitle search [enable]
	REM echo   --disable-preview         disable video preview [enable]
	REM echo   --disable-log-smplayer    disable smplayer logging [enable]
	REM echo   --disable-log-mplayer     disable mplayer logging [enable]
	REM echo   --disable-gui-runtime     disable runtime GUI switching [enable]
	REM echo   --disable-skins           disable skins [enable]
	echo.
	echo Installation directories:
	echo   --prefix=PREFIX         install architecture-independent files in PREFIX [%prefix_dir%]
	echo.
	echo Note: Both SMPlayer and SMTube sources must be on the same partition as your compiler.
	echo.
	goto exit

) else IF [%1]==[--enable-portable] (

	set QMAKE_DEFS="DEFINES+=PORTABLE_APP"
	set SMTUBE_PARAMS=pe
	set def_portable=enabled

) else IF [%1]==[--disable-smtube] (

	set def_smtube=disabled

) else IF [%1]==[--prefix] (

	set prefix_dir=%2
	shift

) else (

echo configure: error: unrecognized option: `%1'
echo Try `%script_name% --help' for more information
goto exit

) 

shift

goto arg_loop

:done

echo SMPlayer will be built with the following options:
echo.
echo	Portable:     %def_portable%
echo	SMTube:       %def_smtube%
echo.
echo	Install prefix: %prefix_dir%
echo.

call getrev.cmd

if "%~1" == "pe" (
	echo Compiling SMPlayer Portable Edition
	echo.

)

cd zlib
mingw32-make -fwin32\makefile.gcc

cd ..\src
lrelease smplayer.pro
qmake %QMAKE_DEFS%
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
